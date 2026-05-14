<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Weather extends Model
{
    protected $fillable = [
      'title_uz',
      'title_ru',
      'title_en',
      'image',
    ];

    public function child(){
      return $this->hasMany('\App\Models\WeatherUSD', 'weather_id', 'id');
    }


    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        $column = "title_" . $locale;
        return $this->{$column};
    }
}
