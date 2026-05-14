<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalArticle extends Model
{
    use HasFactory;

    protected $table = 'journal_articles';

    protected $fillable = [
        'user_id',
        'title_orig',
        'file_path',
        'file_original_name',
        'file_size',
        'status',
        'rejection_reason',
        'plagiarism_percent',
        'technic_id',
        'moderator_id',
        'category',
        'tags',
        'title_publish',
        'description',
        'cover',
        'publish_date',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'tags'         => 'array',
            'publish_date' => 'date',
        ];
    }

    /* ── Statuses ────────────────────────────────────────────── */

    public const ST_TECHNICAL_REVIEW   = 'technical_review';
    public const ST_TECHNIC_REJECTED   = 'technic_rejected';
    public const ST_REVISION_REQUESTED = 'revision_requested';
    public const ST_MODERATOR_ASSIGN   = 'moderator_assign';
    public const ST_PEER_REVIEW        = 'peer_review';
    public const ST_MODERATOR_FINAL    = 'moderator_final';
    public const ST_MODERATOR_REJECTED = 'moderator_rejected';
    public const ST_READY_TO_PUBLISH   = 'ready_to_publish';
    public const ST_PUBLISHED          = 'published';

    public function isRejected(): bool
    {
        return in_array($this->status, [self::ST_TECHNIC_REJECTED, self::ST_MODERATOR_REJECTED], true);
    }

    /** Userga maqolani yangilab qayta yuborishga ruxsat beradigan statuslar */
    public function isResubmittable(): bool
    {
        return in_array($this->status, [
            self::ST_TECHNIC_REJECTED,
            self::ST_MODERATOR_REJECTED,
            self::ST_REVISION_REQUESTED,
        ], true);
    }

    public function isPublished(): bool
    {
        return $this->status === self::ST_PUBLISHED;
    }

    /* ── Relations ───────────────────────────────────────────── */

    public function author()
    {
        return $this->belongsTo(JournalUser::class, 'user_id');
    }

    public function technic()
    {
        return $this->belongsTo(JournalUser::class, 'technic_id');
    }

    public function moderator()
    {
        return $this->belongsTo(JournalUser::class, 'moderator_id');
    }

    public function assignedReviewers()
    {
        return $this->belongsToMany(JournalUser::class, 'journal_article_reviewers', 'article_id', 'reviewer_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(JournalReview::class, 'article_id');
    }

    public function history()
    {
        return $this->hasMany(JournalHistory::class, 'article_id')->orderBy('created_at', 'desc');
    }
}
