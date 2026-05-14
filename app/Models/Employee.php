<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Employee extends Model
{
    protected $fillable = [
        'name_uz', 'name_ru', 'name_en',
        'position_uz', 'position_ru', 'position_en',
        'project_uz', 'project_ru', 'project_en',
        'email', 'image', 'head_id',
        'is_vacant', 'sort',
    ];

    protected $casts = [
        'is_vacant' => 'boolean',
        'head_id'   => 'integer',
        'sort'      => 'integer',
    ];

    public function head()
    {
        return $this->belongsTo(self::class, 'head_id');
    }

    public function team()
    {
        return $this->hasMany(self::class, 'head_id')->orderBy('sort')->orderBy('id');
    }

    public function getNameAttribute()
    {
        $locale = App::getLocale();
        $col    = "name_" . $locale;
        return $this->{$col};
    }

    public function getPositionAttribute()
    {
        $locale = App::getLocale();
        $col    = "position_" . $locale;
        return $this->{$col};
    }

    public function getProjectAttribute()
    {
        $locale = App::getLocale();
        $col    = "project_" . $locale;
        return $this->{$col};
    }
}
