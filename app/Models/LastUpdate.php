<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastUpdate extends Model
{
    protected $fillable = [
      'created_at',
      'updated_at'
    ];
}
