<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalReview extends Model
{
    protected $table = 'journal_reviews';

    protected $fillable = [
        'article_id',
        'reviewer_id',
        'score_research_name',
        'score_topic_relevance',
        'score_problem_analysis',
        'score_problem_solutions',
        'score_recommendations',
        'score_originality',
        'score_clarity',
        'decision',
        'comment',
        'rejection_reason',
    ];

    public const DEC_ACCEPT_NO_REVIEW   = 'accept_no_review';
    public const DEC_ACCEPT_WITH_REVIEW = 'accept_with_review';
    public const DEC_REJECT             = 'reject';

    public const SCORE_FIELDS = [
        'score_research_name',
        'score_topic_relevance',
        'score_problem_analysis',
        'score_problem_solutions',
        'score_recommendations',
        'score_originality',
        'score_clarity',
    ];

    public function averageScore(): ?float
    {
        $scores = collect(self::SCORE_FIELDS)
            ->map(fn ($f) => $this->{$f})
            ->filter(fn ($v) => $v !== null);

        if ($scores->isEmpty()) return null;

        return round($scores->avg(), 2);
    }

    public function article()
    {
        return $this->belongsTo(JournalArticle::class, 'article_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(JournalUser::class, 'reviewer_id');
    }
}
