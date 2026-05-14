<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Structure extends Model
{
  protected $fillable = [
    'title_uz',
    'title_ru',
    'title_en',
    'is_parent',
    'column',
    'slug',
    'sort',
    'type',
  ];


  public function getTitleAttribute()
  {
      $locale = App::getLocale();
      $column = "title_" . $locale;
      return $this->{$column};
  }

}
