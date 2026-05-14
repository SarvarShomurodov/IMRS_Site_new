<?php

namespace App\Http\Controllers\JournalSite;

use App\Http\Controllers\Controller;
use App\Models\JournalArticle;
use App\Models\JournalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CabinetController extends Controller
{
    /* ── Dashboard ──────────────────────────────────────────── */

    public function dashboard()
    {
        $user = Auth::guard('journal')->user();

        // Boshqa rollarni o'z panellariga yo'naltirish
        if ($user->isTechnic())    return redirect()->route('journal.technic.dashboard');
        if ($user->isModerator())  return redirect()->route('journal.moderator.dashboard');
        if ($user->isReviewer())   return redirect()->route('journal.reviewer.dashboard');
        if ($user->isSuperAdmin()) return redirect()->route('journal.admin.users');

        $base = JournalArticle::query()->where('user_id', $user->id);

        $stats = [
            'total'     => (clone $base)->count(),
            'in_review' => (clone $base)->whereIn('status', [
                JournalArticle::ST_TECHNICAL_REVIEW,
                JournalArticle::ST_MODERATOR_ASSIGN,
                JournalArticle::ST_PEER_REVIEW,
                JournalArticle::ST_MODERATOR_FINAL,
                JournalArticle::ST_READY_TO_PUBLISH,
            ])->count(),
            'published' => (clone $base)->where('status', JournalArticle::ST_PUBLISHED)->count(),
            'rejected'  => (clone $base)->whereIn('status', [
                JournalArticle::ST_TECHNIC_REJECTED,
                JournalArticle::ST_MODERATOR_REJECTED,
            ])->count(),
        ];

        $recent = (clone $base)->orderByDesc('created_at')->limit(5)->get();

        return view('client.journal_site.cabinet.dashboard', compact('user', 'stats', 'recent'));
    }

    /* ── Articles list ──────────────────────────────────────── */

    public function articles()
    {
        $user = Auth::guard('journal')->user();

        $articles = JournalArticle::query()
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('client.journal_site.cabinet.articles', compact('user', 'articles'));
    }

    /* ── Submit form ────────────────────────────────────────── */

    public function showSubmit()
    {
        $user = Auth::guard('journal')->user();
        return view('client.journal_site.cabinet.submit', compact('user'));
    }

    public function submit(Request $request)
    {
        $user = Auth::guard('journal')->user();

        $data = $request->validate([
            'title' => ['required', 'string', 'min:8', 'max:255'],
            'file'  => ['required', 'file', 'mimes:doc,docx', 'max:30720'], // 30MB
        ], [
            'file.mimes' => __('validation.mimes', ['attribute' => 'file', 'values' => 'doc, docx']),
            'file.max'   => 'Fayl 30 MB dan oshmasligi kerak',
        ]);

        // Store file
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filename = 'article-'.$user->id.'-'.time().'-'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('journal/articles', $filename, 'public');

        // Create article
        $article = JournalArticle::create([
            'user_id'            => $user->id,
            'title_orig'         => $data['title'],
            'file_path'          => $path,
            'file_original_name' => $originalName,
            'file_size'          => $file->getSize(),
            'status'             => JournalArticle::ST_TECHNICAL_REVIEW,
        ]);

        // History log
        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'submitted',
            'from_status' => null,
            'to_status'   => JournalArticle::ST_TECHNICAL_REVIEW,
        ]);

        return redirect()->route('journal.cabinet.articles')
            ->with('success', __('journal.cab.submit_success'));
    }

    /* ── Article detail ─────────────────────────────────────── */

    public function articleDetail(int $id)
    {
        $user = Auth::guard('journal')->user();

        $article = JournalArticle::with(['history.user'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return view('client.journal_site.cabinet.article', compact('user', 'article'));
    }

    /* ── Re-submit (rad etilgan / revision_requested maqolani yangilash) ── */

    public function showResubmit(int $id)
    {
        $user = Auth::guard('journal')->user();

        $article = JournalArticle::where('user_id', $user->id)->findOrFail($id);

        if (!$article->isResubmittable()) {
            return redirect()->route('journal.cabinet.article', $article->id)
                ->with('error', __('journal.cab.resubmit_not_allowed'));
        }

        return view('client.journal_site.cabinet.resubmit', compact('user', 'article'));
    }

    public function resubmit(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();

        $article = JournalArticle::where('user_id', $user->id)->findOrFail($id);

        if (!$article->isResubmittable()) {
            return redirect()->route('journal.cabinet.article', $article->id)
                ->with('error', __('journal.cab.resubmit_not_allowed'));
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'min:8', 'max:255'],
            'file'  => ['nullable', 'file', 'mimes:doc,docx', 'max:30720'],
        ], [
            'file.mimes' => __('validation.mimes', ['attribute' => 'file', 'values' => 'doc, docx']),
            'file.max'   => __('journal.cab.file_max'),
        ]);

        $from = $article->status;
        $updates = [
            'title_orig' => $data['title'],
            'status'     => JournalArticle::ST_TECHNICAL_REVIEW,
            // Eski rad etish sababini va plagiarism foizini saqlab qolamiz tarixda,
            // lekin maqola endi yangi tekshiruvga kiradi
        ];

        if ($request->hasFile('file')) {
            // Eski faylni o'chiramiz (agar bo'lsa)
            if ($article->file_path && Storage::disk('public')->exists($article->file_path)) {
                Storage::disk('public')->delete($article->file_path);
            }
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filename = 'article-'.$user->id.'-'.time().'-'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('journal/articles', $filename, 'public');

            $updates['file_path']          = $path;
            $updates['file_original_name'] = $originalName;
            $updates['file_size']          = $file->getSize();
        }

        $article->update($updates);

        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'resubmitted',
            'from_status' => $from,
            'to_status'   => JournalArticle::ST_TECHNICAL_REVIEW,
        ]);

        return redirect()->route('journal.cabinet.article', $article->id)
            ->with('success', __('journal.cab.resubmit_success'));
    }

    /* ── File download ──────────────────────────────────────── */

    public function downloadFile(int $id)
    {
        $user = Auth::guard('journal')->user();

        $article = JournalArticle::where('user_id', $user->id)->findOrFail($id);

        if (!$article->file_path || !Storage::disk('public')->exists($article->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $article->file_path,
            $article->file_original_name ?: basename($article->file_path)
        );
    }
}
