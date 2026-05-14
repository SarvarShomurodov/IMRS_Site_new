<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LawCategory;

class LawCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $category = new LawCategory();
      $category->title_uz = "Huquqiy va me'yoriy-huquqiy baza";
      $category->title_ru = 'Нормативно-правовая база';
      $category->title_en = 'Legal and regulatory framework';
      $category->parent_id = 0;
      $category->slug      = '#';
      $category->save();

      $category = new LawCategory();
      $category->title_uz = "Qonunlar va kodekslar";
      $category->title_ru = 'Законы и кодексы';
      $category->title_en = 'Laws and codes';
      $category->parent_id = 1;
      $category->slug      = 'laws-and-codes';
      $category->save();

      $category = new LawCategory();
      $category->title_uz = "Farmonlar";
      $category->title_ru = 'Указы';
      $category->title_en = 'Decrees';
      $category->parent_id = 1;
      $category->slug      = 'decrees';
      $category->save();
    }
}
