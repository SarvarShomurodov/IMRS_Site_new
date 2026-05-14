<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App;

class LawCategory extends Model
{
    protected $fillable = [
      'title_uz',
      'title_ru',
      'title_en',
      'slug',
      'parent_id',
      'meta_keywords_uz',
      'meta_keywords_ru',
      'meta_keywords_en',
      'meta_description_uz',
      'meta_description_ru',
      'meta_description_en',
    ];

    public function child(){
      return $this->hasMany('App\\Models\\LawCategory', 'parent_id', 'id');
    }


    public function parent(){
      return $this->hasOne('App\\Models\\LawCategory', 'id', 'parent_id');
    }


    public function laws(){
      return $this->hasMany('App\\Models\\Law', 'category_id', 'id');
    }


    public function items(){
      return $this->hasMany('App\\Models\\Law', 'category_id', 'id');
    }


    public function getSlug()
    {
      if($this->child()->exists() && !$this->parent()->exists()){
        return "#";
      }elseif($this->parent()->exists()){
        return "/laws/$this->slug";
      }elseif(!$this->child()->exists() && !$this->parent()->exists()){
        return "/laws/$this->slug";
      }
    }

    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        $column = "title_" . $locale;
        return $this->{$column};
    }

    public function getShortDescriptionAttribute()
    {
        $locale = App::getLocale();
        $column = "description_" . $locale;
        return mb_strimwidth($this->{$column}, 0, 200, "...");
    }

    public function getDescriptionAttribute()
    {
        $locale = App::getLocale();
        $column = "description_" . $locale;
        return $this->{$column};
    }

    public function getImageAttribute()
    {
        $locale = App::getLocale();
        $column = "image_" . $locale;
        return "/images/news/" . $locale ."/". $this->{$column};
    }

    public function getCreatedData()
    {
        $locale = App::getLocale();
        Carbon::setlocale($locale);

        return Carbon::parse($this->created_at)->translatedFormat(' j F Y');
    }

    public function getMonthData()
    {
        $locale = App::getLocale();
        Carbon::setlocale($locale);

        return Carbon::parse($this->created_at)->translatedFormat('M');
    }

    public function getDayData()
    {
        $locale = App::getLocale();
        Carbon::setlocale($locale);

        return Carbon::parse($this->created_at)->translatedFormat('j');
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
