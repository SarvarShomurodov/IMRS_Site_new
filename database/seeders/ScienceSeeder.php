<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scholar;
use App\Models\ScholarWord;

class ScienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $scholar = new Scholar();
      $scholar->name_uz = "Maxmudov Mirabbos Fazliddinovich";
      $scholar->name_ru = "Махмудов Мираббос Фазлиддинович";
      $scholar->name_en = "Makhmudov Mirabbos Fazliddinovich";
      $scholar->theme_uz = "Hududlarda sanoatni rivojlantirishda ishlab chiqarish salohiyatidan samarali foydalanish yo'nalishlari (Qashqadaryo viloyati misolida) ";
      $scholar->theme_ru = "Направления эффективного использования производственного потенциала в развитии промышленности в регионах (на примере Кашкадарьинской области) »";
      $scholar->theme_en = "Directions for the effective use of production potential in the development of industry in the regions (on the example of Kashkadarya region) ";
      $scholar->phddsc_uz = 'PHD';
      $scholar->phddsc_ru = 'PHD';
      $scholar->phddsc_en = 'PHD';
      $scholar->image = '1.jpg';
      $scholar->place_uz = "2019 yil 20-dekabr, vaqt 14:00. IPMI, konferentsiya xonasi";
      $scholar->place_ru = "20 декабря 2019 года, время 14:00. ИПМИ, конференц-зал";
      $scholar->place_en = "December 20, 2019, time 14:00. IPMI, conference hall";
      $scholar->save();


      $word = new ScholarWord();
      $word->word = '1.docx';
      $word->save();
    }
}
