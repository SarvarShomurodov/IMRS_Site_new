<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Law;

class LawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $law = new Law();
        $law->title_uz     = "O'zbekiston Respublikasining 1995 yil 21 dekabrdagi 167-I-sonli «O'zbekiston Respublikasining davlat tili to'g'risida gi qonunga o'zgartish va qo'shimchalar kiritish to'g'risida» gi qonuni.";
        $law->title_ru     = "Закон Республики Узбекистан №167-I от 21 декабря 1995 г. «О внесении изменений и дополнений в Закон «О государственном языке Республики Узбекистан»";
        $law->title_en     = "Law of the Republic of Uzbekistan No. 167-I of December 21, 1995 «On Amendments and Additions to the Law On the State Language of the Republic of Uzbekistan";
        $law->category_id  = 2;
        $law->slug_uz      = "https://lex.uz/docs/121433";
        $law->slug_ru      = "https://lex.uz/docs/121433";
        $law->slug_en      = "https://lex.uz/docs/121433";
        $law->save();

        $law = new Law();
        $law->title_uz     = "O'zbekiston Respublikasi Prezidentining «Iqtisodiy rivojlanish va qashshoqlikni kamaytirish sohasidagi davlat siyosatini tubdan yangilash chora-tadbirlari to'g'risida» 2020 yil 26 martdagi UP-5975-sonli Farmoni.";
        $law->title_ru     = "Указ Президента Республики Узбекистан №УП-5975 от 26 марта 2020 г. «О мерах по кардинальному обновлению государственной политики в сфере развития экономики и сокращения бедности»";
        $law->title_en     = "Decree of the President of the Republic of Uzbekistan No. UP-5975 of March 26, 2020 «On measures to radically update state policy in the field of economic development and poverty reduction»";
        $law->category_id  = 3;
        $law->slug_uz      = "https://lex.uz/ru/docs/4778531";
        $law->slug_ru      = "https://lex.uz/ru/docs/4778531";
        $law->slug_en      = "https://lex.uz/ru/docs/4778531";
        $law->save();
    }
}
