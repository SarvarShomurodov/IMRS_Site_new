<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
      'name',
      'address',
      'phone',
      'email',
      'content',
      'status'
    ];


    public function getShortContentAttribute()
    {
        return mb_strimwidth($this->content, 0, 100, "...");
    }
}
