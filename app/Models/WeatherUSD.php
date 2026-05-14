<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class WeatherUSD extends Model
{
    protected $fillable = [
      'weather_from',
      'weather_to',
      'weather_id',
      'usd_from',
      'usd_to',
    ];


    public function weather(){
      return $this->hasOne('\App\Models\Weather', 'id', 'weather_id');
    }
}
