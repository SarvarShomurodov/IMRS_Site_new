<?php

namespace App\Http\Controllers\JournalSite;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\JournalArticle;
use App\Models\JournalHistory;
use App\Models\JournalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModeratorController extends Controller
{
    public const CATEGORIES = [
        'AI', 'Makroiqtisodiyot', 'Investitsiya', 'Biznes', 'Yangiliklar', 'Buxgalteriya',
    ];

    /* ── Dashboard ──────────────────────────────────────────── */

    public function dashboard()
    {
        $user = Auth::guard('journal')->user();

        $stats = [
            'inbox'     => JournalArticle::where('status', JournalArticle::ST_MODERATOR_ASSIGN)->count(),
            'in_review' => JournalArticle::where('status', JournalArticle::ST_PEER_REVIEW)->count(),
            'final'     => JournalArticle::where('status', JournalArticle::ST_MODERATOR_FINAL)->count(),
            'total'     => JournalArticle::count(),
        ];

        $recentInbox = JournalArticle::with('author')
            ->where('status', JournalArticle::ST_MODERATOR_ASSIGN)
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        $recentFinal = JournalArticle::with('author')
            ->where('status', JournalArticle::ST_MODERATOR_FINAL)
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        return view('client.journal_site.moderator.dashboard', compact('user', 'stats', 'recentInbox', 'recentFinal'));
    }

    /* ── Inbox (moderator_assign) ────────────────────────────── */

    public function inbox()
    {
        $user = Auth::guard('journal')->user();

        $articles = JournalArticle::with('author')
            ->where('status', JournalArticle::ST_MODERATOR_ASSIGN)
            ->orderBy('updated_at', 'asc')
            ->paginate(15);

        return view('client.journal_site.moderator.inbox', compact('user', 'articles'));
    }

    /* ── In review (peer_review) ─────────────────────────────── */

    public function inReview()
    {
        $user = Auth::guard('journal')->user();

        $articles = JournalArticle::with(['author', 'assignedReviewers', 'reviews'])
            ->where('status', JournalArticle::ST_PEER_REVIEW)
            ->orderBy('updated_at', 'asc')
            ->paginate(15);

        return view('client.journal_site.moderator.in-review', compact('user', 'articles'));
    }

    /* ── Final queue (moderator_final) ───────────────────────── */

    public function finalQueue()
    {
        $user = Auth::guard('journal')->user();

        $articles = JournalArticle::with(['author', 'reviews'])
            ->where('status', JournalArticle::ST_MODERATOR_FINAL)
            ->orderBy('updated_at', 'asc')
            ->paginate(15);

        return view('client.journal_site.moderator.final-queue', compact('user', 'articles'));
    }

    /* ── All (with status filter) ────────────────────────────── */

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

        return view('client.journal_site.moderator.all', compact('user', 'articles', 'status', 'statusCounts'));
    }

    /* ── Article detail (multi-state) ────────────────────────── */

    public function article(int $id)
    {
        $user = Auth::guard('journal')->user();

        $article = JournalArticle::with([
            'author',
            'history.user',
            'assignedReviewers',
            'reviews.reviewer',
            'technic',
        ])->findOrFail($id);

        // Available reviewers (faqat reviewer rolidagilar)
        $availableReviewers = JournalUser::where('role', JournalUser::ROLE_REVIEWER)
            ->withCount(['reviewsGiven'])
            ->orderBy('last_name')
            ->get();

        $categories = self::CATEGORIES;

        return view('client.journal_site.moderator.article', compact(
            'user', 'article', 'availableReviewers', 'categories'
        ));
    }

    /* ── Assign reviewers (moderator_assign → peer_review) ──── */

    public function assignReviewers(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        if ($article->status !== JournalArticle::ST_MODERATOR_ASSIGN) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'reviewer_ids'   => ['required', 'array', 'min:1', 'max:3'],
            'reviewer_ids.*' => ['integer', 'exists:journal_users,id'],
        ], [
            'reviewer_ids.required' => __('journal.mod.select_min'),
            'reviewer_ids.min'      => __('journal.mod.select_min'),
            'reviewer_ids.max'      => __('journal.mod.select_max'),
        ]);

        // Faqat reviewer roldagilarni qabul qilamiz
        $validReviewers = JournalUser::whereIn('id', $data['reviewer_ids'])
            ->where('role', JournalUser::ROLE_REVIEWER)
            ->pluck('id')->all();

        if (count($validReviewers) === 0) {
            return back()->with('error', __('journal.mod.select_min'));
        }

        DB::transaction(function () use ($article, $validReviewers, $user) {
            $from = $article->status;

            // Eski tayinlangan taqrizchilarni tozalash (agar bo'lsa) va yangilarini biriktirish
            $article->assignedReviewers()->sync(
                collect($validReviewers)->mapWithKeys(fn ($rid) => [$rid => ['status' => 'pending']])->all()
            );

            $article->update([
                'status'       => JournalArticle::ST_PEER_REVIEW,
                'moderator_id' => $user->id,
            ]);

            JournalHistory::create([
                'article_id'  => $article->id,
                'user_id'     => $user->id,
                'action'      => 'reviewers_assigned',
                'from_status' => $from,
                'to_status'   => JournalArticle::ST_PEER_REVIEW,
                'payload'     => ['reviewer_ids' => $validReviewers],
            ]);
        });

        return redirect()->route('journal.moderator.inbox')
            ->with('success', __('journal.mod.assigned_msg'));
    }

    /* ── Final approve (moderator_final → ready_to_publish) ── */

    public function finalApprove(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        if ($article->status !== JournalArticle::ST_MODERATOR_FINAL) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'category' => ['required', 'string', 'in:'.implode(',', self::CATEGORIES)],
            'tags'     => ['nullable', 'string', 'max:500'],
        ], [
            'category.required' => __('journal.mod.category_required'),
            'category.in'       => __('journal.mod.category_required'),
        ]);

        // Tags: vergul/space bilan ajratilgan, max 8
        $tags = collect(preg_split('/[,;\n]+/', (string) ($data['tags'] ?? '')))
            ->map(fn ($t) => trim(ltrim($t, '#')))
            ->filter()
            ->unique()
            ->take(8)
            ->values()
            ->all();

        $from = $article->status;
        $article->update([
            'status'       => JournalArticle::ST_READY_TO_PUBLISH,
            'category'     => $data['category'],
            'tags'         => $tags,
            'moderator_id' => $user->id,
        ]);

        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'moderator_final_approved',
            'from_status' => $from,
            'to_status'   => JournalArticle::ST_READY_TO_PUBLISH,
            'payload'     => ['category' => $data['category'], 'tags' => $tags],
        ]);

        return redirect()->route('journal.moderator.final_queue')
            ->with('success', __('journal.mod.final_approved_msg'));
    }

    /* ── Reassign reviewers (peer_review/moderator_final → peer_review with new reviewers) ── */

    public function reassignReviewers(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        // Faqat peer_review yoki moderator_final statusida qayta tayinlash mumkin
        if (!in_array($article->status, [JournalArticle::ST_PEER_REVIEW, JournalArticle::ST_MODERATOR_FINAL], true)) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'reviewer_ids'   => ['required', 'array', 'min:1', 'max:3'],
            'reviewer_ids.*' => ['integer', 'exists:journal_users,id'],
        ], [
            'reviewer_ids.required' => __('journal.mod.select_min'),
            'reviewer_ids.min'      => __('journal.mod.select_min'),
            'reviewer_ids.max'      => __('journal.mod.select_max'),
        ]);

        $validReviewers = JournalUser::whereIn('id', $data['reviewer_ids'])
            ->where('role', JournalUser::ROLE_REVIEWER)
            ->pluck('id')->all();

        if (count($validReviewers) === 0) {
            return back()->with('error', __('journal.mod.select_min'));
        }

        DB::transaction(function () use ($article, $validReviewers, $user) {
            $from = $article->status;

            // Yangi taqrizchilarni biriktiramiz (eski biriktirishlar tozalanadi).
            // Eski review yozuvlari (journal_reviews) tarix uchun saqlanib qoladi.
            $article->assignedReviewers()->sync(
                collect($validReviewers)->mapWithKeys(fn ($rid) => [$rid => ['status' => 'pending']])->all()
            );

            $article->update([
                'status'       => JournalArticle::ST_PEER_REVIEW,
                'moderator_id' => $user->id,
            ]);

            JournalHistory::create([
                'article_id'  => $article->id,
                'user_id'     => $user->id,
                'action'      => 'reviewers_reassigned',
                'from_status' => $from,
                'to_status'   => JournalArticle::ST_PEER_REVIEW,
                'payload'     => ['reviewer_ids' => $validReviewers],
            ]);
        });

        return redirect()->route('journal.moderator.article', $article->id)
            ->with('success', __('journal.mod.reassigned_msg'));
    }

    /* ── Final reject (moderator_final → moderator_rejected) ── */

    public function finalReject(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();
        $article = JournalArticle::findOrFail($id);

        if ($article->status !== JournalArticle::ST_MODERATOR_FINAL) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:1500'],
        ]);

        $from = $article->status;
        $article->update([
            'status'           => JournalArticle::ST_MODERATOR_REJECTED,
            'rejection_reason' => $data['reason'],
            'moderator_id'     => $user->id,
        ]);

        JournalHistory::create([
            'article_id'  => $article->id,
            'user_id'     => $user->id,
            'action'      => 'moderator_final_rejected',
            'from_status' => $from,
            'to_status'   => JournalArticle::ST_MODERATOR_REJECTED,
            'comment'     => $data['reason'],
        ]);

        return redirect()->route('journal.moderator.final_queue')
            ->with('success', __('journal.mod.final_rejected_msg'));
    }

    /* ── File download ──────────────────────────────────────── */

    public function downloadFile(int $id)
    {
        $article = JournalArticle::findOrFail($id);

        if (!$article->file_path || !Storage::disk('public')->exists($article->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $article->file_path,
            $article->file_original_name ?: basename($article->file_path)
        );
    }

    /* ── Jurnal sonlari (PDF nashrlar) ──────────────────────── */

    public function issuesIndex()
    {
        $user   = Auth::guard('journal')->user();
        $issues = Journal::orderByDesc('id')->paginate(20);

        return view('client.journal_site.moderator.issues', compact('user', 'issues'));
    }

    public function issuesStore(Request $request)
    {
        $data = $request->validate([
            'title_uz' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'time_uz'  => 'nullable|string|max:120',
            'time_ru'  => 'nullable|string|max:120',
            'time_en'  => 'nullable|string|max:120',
            'issn'     => 'nullable|string|max:60',
            'sort'     => 'nullable|integer|min:0|max:255',
            'image'    => 'nullable|image|max:5120',                         // 5 MB
            'pdf'      => 'required|file|mimes:pdf|max:30720',               // 30 MB
        ], [
            'pdf.max'   => __('journal.mod.issue_err_pdf_size', ['mb' => 30]),
            'pdf.mimes' => __('journal.mod.issue_err_pdf_mime'),
        ]);

        $pdfDir = public_path('files/journals');
        if (!is_dir($pdfDir)) {
            @mkdir($pdfDir, 0775, true);
        }
        $pdf = $request->file('pdf');
        $pdfName = 'issue-' . time() . '-' . \Illuminate\Support\Str::random(6) . '.' . $pdf->getClientOriginalExtension();
        $pdf->move($pdfDir, $pdfName);

        $imgName = '';
        if ($request->hasFile('image')) {
            $imgDir = public_path('images/journals');
            if (!is_dir($imgDir)) {
                @mkdir($imgDir, 0775, true);
            }
            $img = $request->file('image');
            $imgName = 'cover-' . time() . '-' . \Illuminate\Support\Str::random(6) . '.' . $img->getClientOriginalExtension();
            $img->move($imgDir, $imgName);
        }

        Journal::create([
            'title_uz'                => $data['title_uz'],
            'title_ru'                => $data['title_ru'],
            'title_en'                => $data['title_en'],
            'image'                   => $imgName,
            'journal'                 => $pdfName,
            'time_uz'                 => $data['time_uz'] ?? '',
            'time_ru'                 => $data['time_ru'] ?? '',
            'time_en'                 => $data['time_en'] ?? '',
            'sort'                    => $data['sort'] ?? 1,
            'issn'                    => $data['issn'] ?? null,
            'editorial_staff_uz'      => '', 'editorial_staff_ru' => '', 'editorial_staff_en' => '',
            'editorial_board_uz'      => '', 'editorial_board_ru' => '', 'editorial_board_en' => '',
            'submission_uz'           => '', 'submission_ru'      => '', 'submission_en'      => '',
            'news_uz'                 => '', 'news_ru'            => '', 'news_en'            => '',
            'subscription_uz'         => '', 'subscription_ru'    => '', 'subscription_en'    => '',
            'contacts_uz'             => '', 'contacts_ru'        => '', 'contacts_en'        => '',
            'views'                   => 0,
        ]);

        return redirect()->route('journal.moderator.issues.index')
            ->with('success', __('journal.mod.issue_created_msg'));
    }

    public function issuesDestroy(int $id)
    {
        $issue = Journal::findOrFail($id);

        if ($issue->journal) {
            $pdfPath = public_path('files/journals/' . $issue->journal);
            if (is_file($pdfPath)) {
                @unlink($pdfPath);
            }
        }
        if ($issue->image) {
            $imgPath = public_path('images/journals/' . $issue->image);
            if (is_file($imgPath)) {
                @unlink($imgPath);
            }
        }

        $issue->delete();

        return redirect()->route('journal.moderator.issues.index')
            ->with('success', __('journal.mod.issue_deleted_msg'));
    }
}
