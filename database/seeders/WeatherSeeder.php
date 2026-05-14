<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\MOdels\WeatherUSD;
use App\MOdels\Weather;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = new Weather();
        $item->title_uz = 'Bulutli';
        $item->title_ru = 'Облачно';
        $item->title_en = 'Cloudly';
        $item->image = '1.png';
        $item->save();

        $item = new Weather();
        $item->title_uz = 'Qor';
        $item->title_ru = 'Снег';
        $item->title_en = 'Snow';
        $item->image = '2.png';
        $item->save();



        $item = new WeatherUSD();
        $item->weather_from = '-3';
        $item->weather_to = '-11';
        $item->weather_id = 1;
        $item->usd_from = '10380.00';
        $item->usd_to = '10430.00';
        $item->save();
    }
}
