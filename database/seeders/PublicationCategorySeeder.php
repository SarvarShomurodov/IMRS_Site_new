<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicationCategory;

class PublicationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new PublicationCategory();
        $category->title_uz = 'Maqolalar va tezislar';
        $category->title_ru = 'Статьи и тезисы';
        $category->title_en = 'Articles and abstracts';
        $category->slug = 'articles-and-abstracts';
        $category->meta_description_uz = 'Maqolalar va tezislar';
        $category->meta_description_ru = 'Статьи и тезисы';
        $category->meta_description_en = 'Articles and abstracts';
        $category->meta_keywords_uz = 'Maqolalar va tezislar';
        $category->meta_keywords_ru = 'Статьи и тезисы';
        $category->meta_keywords_en = 'Articles and abstracts';
        $category->save();

        $category = new PublicationCategory();
        $category->title_uz = "Sanoat sektori bo'yicha sharhlar";
        $category->title_ru = 'Обзоры по отраслям экономики';
        $category->title_en = 'Reviews by industry sector';
        $category->slug = 'reviews-by-industry-sector';
        $category->meta_description_uz = "Sanoat sektori bo'yicha sharhlar";
        $category->meta_description_ru = 'Обзоры по отраслям экономики';
        $category->meta_description_en = 'Reviews by industry sector';
        $category->meta_keywords_uz = "Sanoat sektori bo'yicha sharhlar";
        $category->meta_keywords_ru = 'Обзоры по отраслям экономики';
        $category->meta_keywords_en = 'Reviews by industry sector';
        $category->save();

        $category = new PublicationCategory();
        $category->title_uz = 'Makroiqtisodiyot';
        $category->title_ru = 'Макроэкономика';
        $category->title_en = 'Macroeconomics';
        $category->slug = 'macroeconomics';
        $category->image = '1.jpg';
        $category->parent_id = '2';
        $category->meta_description_uz = 'Makroiqtisodiyot';
        $category->meta_description_ru = 'Макроэкономика';
        $category->meta_description_en = 'Macroeconomics';
        $category->meta_keywords_uz = 'Makroiqtisodiyot';
        $category->meta_keywords_ru = 'Макроэкономика';
        $category->meta_keywords_en = 'Macroeconomics';
        $category->save();

        $category = new PublicationCategory();
        $category->title_uz = 'Jahon oziq-ovqat bozorlari';
        $category->title_ru = 'Мировые рынки прподовольствия';
        $category->title_en = 'World Food Markets';
        $category->slug = 'world-food-markets';
        $category->image = '2.jpg';
        $category->parent_id = '2';
        $category->meta_description_uz = 'Jahon oziq-ovqat bozorlari';
        $category->meta_description_ru = 'Мировые рынки прподовольствия';
        $category->meta_description_en = 'World Food Markets';
        $category->meta_keywords_uz = 'Jahon oziq-ovqat bozorlari';
        $category->meta_keywords_ru = 'Мировые рынки прподовольствия';
        $category->meta_keywords_en = 'World Food Markets';
        $category->save();
    }
}
