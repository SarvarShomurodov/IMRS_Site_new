<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Law extends Model
{
    protected $fillable = [
      'title_uz',
      'title_ru',
      'title_en',
      'slug_uz',
      'slug_ru',
      'slug_en',
      'category_id',
    ];


    public function category(){
      return $this->hasOne('App\\Models\\LawCategory', 'id', 'category_id');
    }


    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        $column = "title_" . $locale;
        return $this->{$column};
    }

    public function getUrlAttribute()
    {
        $locale = App::getLocale();
        $column = "slug_" . $locale;
        return $this->{$column};
    }
}
