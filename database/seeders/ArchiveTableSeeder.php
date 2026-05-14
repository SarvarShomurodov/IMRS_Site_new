<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Archive;

class ArchiveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $archive = new Archive();
        $archive->title_uz = 'Yangiliklar';
        $archive->title_ru = 'Новости';
        $archive->title_en = 'News';
        $archive->slug     = 'news';
        $archive->meta_keywords_uz = 'Yangiliklar, arxivlar';
        $archive->meta_keywords_ru = 'Новости, архивы';
        $archive->meta_keywords_en = 'News, archives';
        $archive->meta_description_uz = 'O\'zbekiston yangiliklari';
        $archive->meta_description_ru = 'Новости Узбекистана';
        $archive->meta_description_en = 'News of Uzbekistan';
        $archive->save();

        $archive = new Archive();
        $archive->title_uz = 'PMTI mutaxassislari OAVda';
        $archive->title_ru = 'Эксперты ИПМИ в СМИ';
        $archive->title_en = 'IFMR experts in media';
        $archive->slug     = 'ifmr-experts-in-media';
        $archive->meta_keywords_uz = 'Yangiliklar, arxivlar';
        $archive->meta_keywords_ru = 'Новости, архивы';
        $archive->meta_keywords_en = 'News, archives';
        $archive->meta_description_uz = 'O\'zbekiston yangiliklari';
        $archive->meta_description_ru = 'Новости Узбекистана';
        $archive->meta_description_en = 'News of Uzbekistan';
        $archive->save();

        $archive = new Archive();
        $archive->title_uz = 'Sharhlar';
        $archive->title_ru = 'Обзоры';
        $archive->title_en = 'Reviews';
        $archive->slug     = 'reviews';
        $archive->meta_keywords_uz = 'Sharhlar';
        $archive->meta_keywords_ru = 'Обзоры';
        $archive->meta_keywords_en = 'Reviews';
        $archive->meta_description_uz = 'Sharhlar';
        $archive->meta_description_ru = 'Обзоры';
        $archive->meta_description_en = 'Reviews';
        $archive->save();
    }
}
