<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App;

class Scholar extends Model
{
    protected $fillable = [
      'name_uz',
      'name_ru',
      'name_en',
      'theme_uz',
      'theme_ru',
      'theme_en',
      'phddsc_uz',
      'phddsc_ru',
      'phddsc_en',
      'image',
      'place_uz',
      'place_ru',
      'place_en',
      'created_at'
    ];


    public function getNameAttribute()
    {
        $locale = App::getLocale();
        $column = "name_" . $locale;
        return $this->{$column};
    }

    public function getThemeAttribute()
    {
        $locale = App::getLocale();
        $column = "theme_" . $locale;
        return mb_strimwidth($this->{$column}, 0, 200, "...");
    }

    public function getPhdDscAttribute()
    {
        $locale = App::getLocale();
        $column = "phddsc_" . $locale;
        return $this->{$column};
    }

    public function getPlaceAttribute()
    {
        $locale = App::getLocale();
        $column = "place_" . $locale;
        return $this->{$column};
    }



    public function getCreatedData()
    {
        $locale = App::getLocale();
        Carbon::setlocale($locale);

        return Carbon::parse($this->created_at)->translatedFormat(' j F Y');
    }

}
