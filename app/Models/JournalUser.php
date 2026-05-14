<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'journal_users';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'password',
        'phone',
        'workplace',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public const ROLE_USER       = 'user';
    public const ROLE_TECHNIC    = 'technic';
    public const ROLE_MODERATOR  = 'moderator';
    public const ROLE_REVIEWER   = 'reviewer';
    public const ROLE_SUPERADMIN = 'superadmin';

    /** Rollar — SuperAdmin tomonidan tayinlanishi mumkin (superadmin'ning o'zi seed orqali). */
    public const ASSIGNABLE_ROLES = [
        self::ROLE_USER,
        self::ROLE_TECHNIC,
        self::ROLE_MODERATOR,
        self::ROLE_REVIEWER,
    ];

    /* ── Helpers ─────────────────────────────────────────────── */

    public function fullName(): string
    {
        return trim($this->last_name.' '.$this->first_name.' '.$this->middle_name);
    }

    public function shortName(): string
    {
        $f = mb_substr($this->first_name, 0, 1);
        return $this->last_name.' '.$f.'.';
    }

    public function isUser(): bool       { return $this->role === self::ROLE_USER; }
    public function isTechnic(): bool    { return $this->role === self::ROLE_TECHNIC; }
    public function isModerator(): bool  { return $this->role === self::ROLE_MODERATOR; }
    public function isReviewer(): bool   { return $this->role === self::ROLE_REVIEWER; }
    public function isSuperAdmin(): bool { return $this->role === self::ROLE_SUPERADMIN; }

    /* ── Relations ───────────────────────────────────────────── */

    public function articles()
    {
        return $this->hasMany(JournalArticle::class, 'user_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(JournalReview::class, 'reviewer_id');
    }
}
