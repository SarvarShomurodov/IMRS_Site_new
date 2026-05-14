<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Slider extends Model
{
      protected $fillable = [
        'image_uz',
        'image_ru',
        'image_en',
        'status',
      ];


      public function getImageAttribute()
      {
          $locale = App::getLocale();
          $column = "image_" . $locale;
          return "/images/sliders/" . $locale ."/". $this->{$column};
      }
}
