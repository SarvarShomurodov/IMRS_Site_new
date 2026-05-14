<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = new Menu();
        $menu->title_uz = 'Biz haqimizda';
        $menu->title_ru = 'О нас';
        $menu->title_en = 'About us';
        $menu->sort     = '1';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Matbuot xizmati';
        $menu->title_ru = 'Пресс-служба';
        $menu->title_en = 'Press service';
        $menu->sort     = '2';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Nashrlar';
        $menu->title_ru = 'Публикации';
        $menu->title_en = 'Publications';
        $menu->sort     = '3';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Ilm fan';
        $menu->title_ru = 'Наука';
        $menu->title_en = 'The science';
        $menu->sort     = '4';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Jurnal';
        $menu->title_ru = 'Журнал';
        $menu->title_en = 'Journal';
        $menu->slug     = 'journals';
        $menu->sort     = '5';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Tarix';
        $menu->title_ru = 'История';
        $menu->title_en = 'History';
        $menu->parent_id= '1';
        $menu->slug     = 'page/history';
        $menu->sort     = '1';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Tuzilma';
        $menu->title_ru = 'Структура';
        $menu->title_en = 'Structure';
        $menu->parent_id= '1';
        $menu->slug     = 'structure';
        $menu->sort     = '3';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Institut menejmenti';
        $menu->title_ru = 'Руководство института';
        $menu->title_en = 'Institute leadership';
        $menu->parent_id= '1';
        $menu->slug     = 'administrations';
        $menu->sort     = '2';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Qonunlar';
        $menu->title_ru = 'Законы';
        $menu->title_en = 'Laws';
        $menu->parent_id= '1';
        $menu->model    = 'LawCategory';
        $menu->slug     = '#';
        $menu->sort     = '4';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Yangiliklar';
        $menu->title_ru = 'Новости';
        $menu->title_en = 'News';
        $menu->parent_id= '2';
        $menu->slug     = 'archives/news';
        $menu->sort     = '1';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'PMTI mutaxassislari OAVda';
        $menu->title_ru = 'Эксперты ИПМИ в СМИ';
        $menu->title_en = 'IFMR experts in media';
        $menu->parent_id= '2';
        $menu->slug     = 'archives/ifmr-experts-in-media';
        $menu->sort     = '1';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'VideoGallereya';
        $menu->title_ru = 'Видеогаллерея';
        $menu->title_en = 'VideoGallery';
        $menu->parent_id= '2';
        $menu->slug     = 'videos';
        $menu->sort     = '4';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Fotogallereya';
        $menu->title_ru = 'Фотогаллерея';
        $menu->title_en = 'Photogallery';
        $menu->parent_id= '2';
        $menu->slug     = 'photos';
        $menu->sort     = '3';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = 'Nashrlar';
        $menu->title_ru = 'Публикации';
        $menu->title_en = 'Publications';
        $menu->parent_id= '3';
        $menu->model    = 'PublicationCategory';
        $menu->slug     = '#';
        $menu->sort     = '1';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = "Ilmiy darajalarni majburlash bo'yicha ilmiy kengash";
        $menu->title_ru = 'Научный совет по принуждению  научных степеней';
        $menu->title_en = 'Scientific Council on Compulsion of Scientific Degrees';
        $menu->parent_id= '4';
        $menu->slug     = '#';
        $menu->sort     = '1';
        $menu->save();

        $menu = new Menu();
        $menu->title_uz = "Himoya deklaratsiyasi";
        $menu->title_ru = 'Объявление о защите';
        $menu->title_en = 'Declaration of protection';
        $menu->parent_id= '15';
        $menu->slug     = 'declaration-of-protection';
        $menu->sort     = '1';
        $menu->save();


    }
}
