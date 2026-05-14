<?php

namespace App\Http\Controllers\JournalSite;

use App\Http\Controllers\Controller;
use App\Models\JournalArticle;
use App\Models\JournalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TechnicController extends Controller
{
    /* ── Dashboard ──────────────────────────────────────────── */

    public function dashboard()
    {
        $user = Auth::guard('journal')->user();

        $stats = [
            'inbox'         => JournalArticle::where('status', JournalArticle::ST_TECHNICAL_REVIEW)->count(),
            'publish_ready' => JournalArticle::where('status', JournalArticle::ST_READY_TO_PUBLISH)->count(),
            'in_review'     => JournalArticle::whereIn('status', [
                JournalArticle::ST_MODERATOR_ASSIGN,
                JournalArticle::ST_PEER_REVIEW,
                JournalArticle::ST_MODERATOR_FINAL,
            ])->count(),
            'total'         => JournalArticle::count(),
        ];

        $recentInbox = JournalArticle::with('author')
            ->where('status', JournalArticle::ST_TECHNICAL_REVIEW)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $recentPublishQueue = JournalArticle::with('author')
            ->where('status', JournalArticle::ST_READY_TO_PUBLISH)
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        return view('client.journal_site.technic.dashboard', compact('user', 'stats', 'recentInbox', 'recentPublishQueue'));
    }

    /* ── Inbox (technical_review status) ─────────────────────── */

    public function inbox()
    {
        $user = Auth::guard('journal')->user();

        $articles = JournalArticle::with('author')
            ->where('status', JournalArticle::ST_TECHNICAL_REVIEW)
            ->orderBy('created_at', 'asc') // FIFO — eng eski avval
            ->paginate(15);

        return view('client.journal_site.technic.inbox', compact('user', 'articles'));
    }

    /* ── Publish queue (ready_to_publish status) ─────────────── */

    public function publishQueue()
    {
        $user = Auth::guard('journal')->user();

        $articles = JournalArticle::with(['author', 'moderator'])
            ->where('status', JournalArticle::ST_READY_TO_PUBLISH)
            ->orderBy('updated_at', 'asc')
            ->paginate(15);

        return view('client.journal_site.technic.publish-queue', compact('user', 'articles'));
    }

    /* ── All articles (with filter) ─────────────────────────── */

    public function all(Request $request)
    {
        $user = Auth::guard('journal')->user();
        $status = (string) $request->input('status');

        $articles = JournalArticle::with('author')
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $statusCounts = JournalArticle::query()
            ->selectRaw('status, COUNT(*) as cnt')
            ->groupBy('status')
            ->pluck('cnt', 'status');

        return view('client.journal_site.technic.all', compact('user', 'articles', 'status', 'statusCounts'));
    }

    /* ── Article detail (review or publish form) ──────────── */

    public function article(int $id)
    {
        $user = Auth::guard('journal')->user();

        $article = JournalArticle::with(['author', 'history.user', 'moderator'])
            ->findOrFail($id);

        return view('client.journal_site.technic.article', compact('user', 'article'));
    }

    /* ── Approve (technical_review → moderator_assign) ────── */

    public function approve(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        if ($article->status !== JournalArticle::ST_TECHNICAL_REVIEW) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'plagiarism_percent' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $from = $article->status;
        $article->update([
            'status'             => JournalArticle::ST_MODERATOR_ASSIGN,
            'technic_id'         => $user->id,
            'plagiarism_percent' => $data['plagiarism_percent'],
        ]);

        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'technic_approved',
            'from_status' => $from,
            'to_status'   => JournalArticle::ST_MODERATOR_ASSIGN,
            'payload'     => ['plagiarism_percent' => $data['plagiarism_percent']],
        ]);

        return redirect()->route('journal.technic.inbox')
            ->with('success', __('journal.tec.approved_msg'));
    }

    /* ── Reject (technical_review → technic_rejected) ─────── */

    public function reject(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        if ($article->status !== JournalArticle::ST_TECHNICAL_REVIEW) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'reason'             => ['required', 'string', 'min:10', 'max:1500'],
            'plagiarism_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $from = $article->status;
        $article->update([
            'status'             => JournalArticle::ST_TECHNIC_REJECTED,
            'rejection_reason'   => $data['reason'],
            'plagiarism_percent' => $data['plagiarism_percent'] ?? $article->plagiarism_percent,
            'technic_id'         => $user->id,
        ]);

        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'technic_rejected',
            'from_status' => $from,
            'to_status'   => JournalArticle::ST_TECHNIC_REJECTED,
            'comment'     => $data['reason'],
            'payload'     => isset($data['plagiarism_percent']) ? ['plagiarism_percent' => $data['plagiarism_percent']] : null,
        ]);

        return redirect()->route('journal.technic.inbox')
            ->with('success', __('journal.tec.rejected_msg'));
    }

    /* ── Request revision (technical_review → revision_requested) ── */

    public function requestRevision(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        if ($article->status !== JournalArticle::ST_TECHNICAL_REVIEW) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'reason'             => ['required', 'string', 'min:10', 'max:1500'],
            'plagiarism_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $from = $article->status;
        $article->update([
            'status'             => JournalArticle::ST_REVISION_REQUESTED,
            'rejection_reason'   => $data['reason'],
            'plagiarism_percent' => $data['plagiarism_percent'] ?? $article->plagiarism_percent,
            'technic_id'         => $user->id,
        ]);

        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'revision_requested',
            'from_status' => $from,
            'to_status'   => JournalArticle::ST_REVISION_REQUESTED,
            'comment'     => $data['reason'],
            'payload'     => isset($data['plagiarism_percent']) ? ['plagiarism_percent' => $data['plagiarism_percent']] : null,
        ]);

        return redirect()->route('journal.technic.inbox')
            ->with('success', __('journal.tec.revision_requested_msg'));
    }

    /* ── Publish (ready_to_publish → published) ──────────── */

    public function publish(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        if ($article->status !== JournalArticle::ST_READY_TO_PUBLISH) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'title_publish' => ['required', 'string', 'min:8', 'max:255'],
            'description'   => ['required', 'string', 'min:30', 'max:500'],
            'publish_date'  => ['required', 'date'],
            'cover'         => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'], // 5 MB
        ]);

        // Store cover image
        $coverFile = $request->file('cover');
        $coverName = 'cover-'.$article->id.'-'.time().'-'.Str::random(8).'.'.$coverFile->getClientOriginalExtension();
        $coverPath = $coverFile->storeAs('journal/covers', $coverName, 'public');

        $from = $article->status;
        $article->update([
            'status'        => JournalArticle::ST_PUBLISHED,
            'title_publish' => $data['title_publish'],
            'description'   => $data['description'],
            'publish_date'  => $data['publish_date'],
            'cover'         => $coverPath,
            'technic_id'    => $user->id,
        ]);

        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'published',
            'from_status' => $from,
            'to_status'   => JournalArticle::ST_PUBLISHED,
        ]);

        return redirect()->route('journal.technic.publish_queue')
            ->with('success', __('journal.tec.published_msg'));
    }

    /* ── File download ──────────────────────────────────────── */

    public function downloadFile(int $id)
    {
        JournalArticle::findOrFail($id); // exists check
        $article = JournalArticle::findOrFail($id);

        if (!$article->file_path || !Storage::disk('public')->exists($article->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $article->file_path,
            $article->file_original_name ?: basename($article->file_path)
        );
    }
}
