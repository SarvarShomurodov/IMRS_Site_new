<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App;

class Menu extends Model
{
  protected $fillable = [
    'title_uz',
    'title_ru',
    'title_en',
    'parent_id',
    'model',
    'slug',
    'sort',
  ];

  public function child(){
    return $this->hasMany('App\\Models\\Menu', 'parent_id', 'id')->orderBy('sort', 'ASC');
  }


  public function parent(){
    return $this->hasOne('App\\Models\\Menu', 'id', 'parent_id');
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


  public function getSlug()
  {
    if(!$this->parent()->exists() && !$this->child()->exists()){
      return "/$this->slug";
    }elseif($this->parent()->exists() && $this->child()->exists()){
      return "#";
    }else{
      return "/$this->slug";
    }

  }
}
