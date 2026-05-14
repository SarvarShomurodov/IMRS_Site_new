<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App;

class Page extends Model
{
  protected $fillable = [
    'title_uz',
    'title_ru',
    'title_en',
    'image_uz',
    'image_ru',
    'image_en',
    'description_uz',
    'description_ru',
    'description_en',
    'pdf_uz',
    'pdf_ru',
    'pdf_en',
    'slug',
    'video_uz',
    'video_ru',
    'video_en',
    'meta_description_uz',
    'meta_description_ru',
    'meta_description_en',
    'meta_keywords_uz',
    'meta_keywords_ru',
    'meta_keywords_en',
  ];


  public function categories() {
    return $this->belongsToMany('App\Models\PageCategories','pages_category');
  }


  public function isVacancy() {
    return $this->categories()->where('slug', 'vacancies')->exists();
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
      return "/images/pages/" . $locale ."/". $this->{$column};
  }

  public function getPdfAttribute()
  {
      $locale = App::getLocale();
      $column = "pdf_" . $locale;
      return "/files/pages/" . $locale ."/". $this->{$column};
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

  public function getVideo()
  {
      $locale = App::getLocale();
      $column = "video_" . $locale;
      return $this->{$column};
  }

  public function issetImage()
  {
      $locale = App::getLocale();
      $column = "image_" . $locale;
      if($this->{$column}){
        return true;
      }else{
        return false;
      }
  }

  public function issetVideo()
  {
      $locale = App::getLocale();
      $column = "video_" . $locale;
      if($this->{$column}){
        return true;
      }else{
        return false;
      }
  }

  public function issetDescription()
  {
      $locale = App::getLocale();
      $column = "description_" . $locale;
      if($this->{$column}){
        return true;
      }else{
        return false;
      }
  }

  public function issetPdf()
  {
      $locale = App::getLocale();
      $column = "pdf_" . $locale;
      if($this->{$column}){
        return true;
      }else{
        return false;
      }
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
