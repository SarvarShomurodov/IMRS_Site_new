<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class PhotoGallery extends Model
{
    protected $fillable = [
      'title_uz',
      'title_ru',
      'title_en',
      'image',
      'status',
      'antonation_uz',
      'antonation_ru',
      'antonation_en',
      'sort'
    ];


    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        $column = "title_" . $locale;
        return $this->{$column};
    }


    public function hashtags(){
      return $this->belongsToMany(\App\Models\HashTag::class, 'infographics_hashtags', 'infographic_id', 'hashtag_id');
    }


    public function getAntonationAttribute()
    {
        $locale = App::getLocale();
        $column = "antonation_" . $locale;
        return $this->{$column};
    }
}
