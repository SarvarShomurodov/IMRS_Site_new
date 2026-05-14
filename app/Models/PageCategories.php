<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class PageCategories extends Model
{
    protected $fillable = [
      'title_uz',
      'title_ru',
      'title_en',
      'slug',
      'meta_keywords_uz',
      'meta_keywords_ru',
      'meta_keywords_en',
      'meta_description_uz',
      'meta_description_ru',
      'meta_description_en',
    ];


    public function pagesAll(){
      return $this->belongsToMany('App\Models\Page', 'pages_category');
    }


    public function pages(){
      return $this->pagesAll()->orderBy('created_at', 'DESC');
    }


    public function getSlug()
    {

        return "/pages/categories/$this->slug";
    }

    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        $column = "title_" . $locale;
        return $this->{$column};
    }


    public function getMetaDescription()
    {
        $locale = App::getLocale();
        $column = "meta_description_" . $locale;
        return $this->{$column};
    }

    public function getMetaKeyword()
    {
        $locale = App::getLocale();
        $column = "meta_keywords_" . $locale;
        return $this->{$column};
    }
}
