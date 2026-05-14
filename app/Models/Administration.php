<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App;

class Administration extends Model
{
  protected $fillable = [
    'title_uz',
    'title_ru',
    'title_en',
    'name_uz',
    'name_ru',
    'name_en',
    'email',
    'phone',
    'image',
    'vacant',
    'duties_uz',
    'duties_ru',
    'duties_en',
    'biography_uz',
    'biography_ru',
    'biography_en',
  ];




  public function getTitleAttribute()
  {
      $locale = App::getLocale();
      $column = "title_" . $locale;
      return $this->{$column};
  }

  public function getNameAttribute()
  {
      $locale = App::getLocale();
      $column = "name_" . $locale;
      return mb_strimwidth($this->{$column}, 0, 200, "...");
  }

  public function getDutiesAttribute()
  {
      $locale = App::getLocale();
      $column = "duties_" . $locale;
      return $this->{$column};
  }

  public function getBiographyAttribute()
  {
    $locale = App::getLocale();
    $column = "biography_" . $locale;
    return $this->{$column};
  }




}
