<?php

namespace App\Http\Controllers\JournalSite;

use App\Http\Controllers\Controller;
use App\Models\JournalArticle;
use App\Models\JournalHistory;
use App\Models\JournalReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReviewerController extends Controller
{
    /* ── Helper: Reviewer'ga tayinlangan maqolalar query ─── */

    private function assignedQuery($userId)
    {
        return JournalArticle::query()
            ->whereHas('assignedReviewers', fn ($q) => $q->where('reviewer_id', $userId));
    }

    /* ── Dashboard ──────────────────────────────────────────── */

    public function dashboard()
    {
        $user = Auth::guard('journal')->user();

        $assigned = $this->assignedQuery($user->id);

        $reviewed = JournalReview::where('reviewer_id', $user->id);

        $allMyScores = collect();
        foreach (JournalReview::where('reviewer_id', $user->id)->get() as $r) {
            foreach (JournalReview::SCORE_FIELDS as $f) {
                if ($r->{$f} !== null) $allMyScores->push($r->{$f});
            }
        }

        $stats = [
            'pending'   => (clone $assigned)
                ->whereHas('assignedReviewers', fn ($q) => $q->where('reviewer_id', $user->id)->where('status', 'pending'))
                ->count(),
            'completed' => $reviewed->count(),
            'total'     => (clone $assigned)->count(),
            'avg_score' => $allMyScores->isEmpty() ? null : round($allMyScores->avg(), 2),
        ];

        $recentInbox = (clone $assigned)
            ->with('author')
            ->whereHas('assignedReviewers', fn ($q) => $q->where('reviewer_id', $user->id)->where('status', 'pending'))
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        return view('client.journal_site.reviewer.dashboard', compact('user', 'stats', 'recentInbox'));
    }

    /* ── Inbox (pending) ─────────────────────────────────────── */

    public function inbox()
    {
        $user = Auth::guard('journal')->user();

        $articles = $this->assignedQuery($user->id)
            ->with('author')
            ->whereHas('assignedReviewers', fn ($q) => $q->where('reviewer_id', $user->id)->where('status', 'pending'))
            ->orderBy('updated_at', 'asc')
            ->paginate(15);

        return view('client.journal_site.reviewer.inbox', compact('user', 'articles'));
    }

    /* ── Completed ───────────────────────────────────────────── */

    public function completed()
    {
        $user = Auth::guard('journal')->user();

        $reviews = JournalReview::with('article.author')
            ->where('reviewer_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('client.journal_site.reviewer.completed', compact('user', 'reviews'));
    }

    /* ── All assignments ─────────────────────────────────────── */

    public function all()
    {
        $user = Auth::guard('journal')->user();

        $articles = $this->assignedQuery($user->id)
            ->with(['author', 'reviews' => fn ($q) => $q->where('reviewer_id', $user->id)])
            ->orderByDesc('updated_at')
            ->paginate(20);

        return view('client.journal_site.reviewer.all', compact('user', 'articles'));
    }

    /* ── Article detail (review form yoki o'z bahosini ko'rish) ── */

    public function article(int $id)
    {
        $user = Auth::guard('journal')->user();

        // Faqat o'ziga tayinlangan maqolalarga ruxsat
        $article = $this->assignedQuery($user->id)
            ->with(['author', 'history.user' => function ($q) {
                // history ham minimal — user faqat asosiy actionlarni ko'radi (not other reviews)
            }])
            ->findOrFail($id);

        // O'zining bahosini topamiz (agar baholagan bo'lsa)
        $myReview = JournalReview::where('article_id', $id)
            ->where('reviewer_id', $user->id)
            ->first();

        // Pivot status
        $pivotStatus = $article->assignedReviewers->where('id', $user->id)->first()?->pivot?->status;

        return view('client.journal_site.reviewer.article', compact('user', 'article', 'myReview', 'pivotStatus'));
    }

    /* ── Submit review (pivot pending → completed) ──────────── */

    public function submit(Request $request, int $id)
    {
        $user = Auth::guard('journal')->user();

        // Article taqriz uchun ekanligini tekshirish
        $article = JournalArticle::findOrFail($id);

        // Reviewer shu maqolaga tayinlanganmi?
        $isAssigned = DB::table('journal_article_reviewers')
            ->where('article_id', $id)
            ->where('reviewer_id', $user->id)
            ->exists();

        if (!$isAssigned) {
            abort(403);
        }

        // Allaqachon baholaganmi?
        if (JournalReview::where('article_id', $id)->where('reviewer_id', $user->id)->exists()) {
            return back()->with('error', __('journal.rev.already_reviewed'));
        }

        // Faqat peer_review statusida qabul qilamiz
        if ($article->status !== JournalArticle::ST_PEER_REVIEW) {
            return back()->with('error', __('journal.tec.invalid_status'));
        }

        $data = $request->validate([
            'score_research_name'     => ['required', 'integer', 'between:2,5'],
            'score_topic_relevance'   => ['required', 'integer', 'between:2,5'],
            'score_problem_analysis'  => ['required', 'integer', 'between:2,5'],
            'score_problem_solutions' => ['required', 'integer', 'between:2,5'],
            'score_recommendations'   => ['required', 'integer', 'between:2,5'],
            'score_originality'       => ['required', 'integer', 'between:2,5'],
            'score_clarity'           => ['required', 'integer', 'between:2,5'],
            'decision'                => ['required', 'in:accept_no_review,accept_with_review,reject'],
            'comment'                 => ['nullable', 'string', 'max:3000'],
            'rejection_reason'        => ['nullable', 'string', 'max:3000'],
        ]);

        DB::transaction(function () use ($article, $user, $data) {
            // Review yozuvi
            JournalReview::create(array_merge($data, [
                'article_id'  => $article->id,
                'reviewer_id' => $user->id,
            ]));

            // Pivot status'ni 'completed' ga o'zgartirish
            DB::table('journal_article_reviewers')
                ->where('article_id', $article->id)
                ->where('reviewer_id', $user->id)
                ->update(['status' => 'completed', 'updated_at' => now()]);

            // History
            JournalHistory::create([
                'article_id'  => $article->id,
                'user_id'     => $user->id,
                'action'      => 'review_completed',
                'from_status' => $article->status,
                'to_status'   => $article->status,
                'payload'     => ['decision' => $data['decision']],
            ]);

            // Avto-transition: agar barcha taqrizchilar tugatgan bo'lsa, moderator_final ga o'tkazish
            $totalAssigned = DB::table('journal_article_reviewers')
                ->where('article_id', $article->id)
                ->count();
            $totalCompleted = DB::table('journal_article_reviewers')
                ->where('article_id', $article->id)
                ->where('status', 'completed')
                ->count();

            if ($totalAssigned > 0 && $totalCompleted >= $totalAssigned) {
                $article->update(['status' => JournalArticle::ST_MODERATOR_FINAL]);

                JournalHistory::create([
                    'article_id'  => $article->id,
                    'user_id'     => null,
                    'action'      => 'all_reviews_completed',
                    'from_status' => JournalArticle::ST_PEER_REVIEW,
                    'to_status'   => JournalArticle::ST_MODERATOR_FINAL,
                ]);
            }
        });

        return redirect()->route('journal.reviewer.completed')
            ->with('success', __('journal.rev.submitted_msg'));
    }

    /* ── File download ──────────────────────────────────────── */

    public function downloadFile(int $id)
    {
        $user = Auth::guard('journal')->user();

        // Faqat o'ziga tayinlangan maqolaga ruxsat
        $article = $this->assignedQuery($user->id)->findOrFail($id);

        if (!$article->file_path || !Storage::disk('public')->exists($article->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $article->file_path,
            $article->file_original_name ?: basename($article->file_path)
        );
    }
}
