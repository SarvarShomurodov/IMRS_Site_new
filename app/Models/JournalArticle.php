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
        'title_publish_uz',
        'title_publish_ru',
        'title_publish_en',
        'description',
        'description_uz',
        'description_ru',
        'description_en',
        'cover',
        'cover_uz',
        'cover_ru',
        'cover_en',
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

    /* ── Ko'p tilli nashr maydonlari ─────────────────────────── */

    public const LOCALES = ['uz', 'ru', 'en'];

    /** Berilgan ustun uchun: joriy til → boshqa mavjud til → eski (neytral) ustun */
    private function localized(string $base, ?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();

        $value = $this->{$base.'_'.$locale} ?? null;
        if (filled($value)) {
            return $value;
        }

        foreach (self::LOCALES as $l) {
            $v = $this->{$base.'_'.$l} ?? null;
            if (filled($v)) {
                return $v;
            }
        }

        return filled($this->{$base}) ? $this->{$base} : null;
    }

    /** Saytda chiqadigan sarlavha (oxirgi chorada title_orig'ga tushadi) */
    public function pubTitle(?string $locale = null): string
    {
        return $this->localized('title_publish', $locale) ?: (string) $this->title_orig;
    }

    /** Tavsif (qisqacha) */
    public function pubDescription(?string $locale = null): string
    {
        return (string) ($this->localized('description', $locale) ?? '');
    }

    /** Muqova rasmining storage yo'li (yo'q bo'lsa null) */
    public function pubCover(?string $locale = null): ?string
    {
        return $this->localized('cover', $locale);
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
