<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalHistory extends Model
{
    protected $table = 'journal_history';

    protected $fillable = [
        'article_id',
        'user_id',
        'action',
        'from_status',
        'to_status',
        'comment',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    public function article()
    {
        return $this->belongsTo(JournalArticle::class, 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(JournalUser::class, 'user_id');
    }
}
