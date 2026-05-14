<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Journal;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $journal = new Journal();
        $journal->title_uz = "Iqtisodiyot: tahlillar va prognozlar №5-6 (7-8)";
        $journal->title_ru = "Экономика: анализ и прогнозы №5-6 (7-8)";
        $journal->title_en = "Economics: analysis and forecasts # 5-6 (7-8)";
        $journal->image   = "1.jpg";
        $journal->journal = "1.pdf";
        $journal->time_uz = "№ 5-6 (7-8)2020 yil may-iyun";
        $journal->time_ru = "№5-6 (7-8)Май-Июнь 2020";
        $journal->time_en = "No. 5-6 (7-8) May-June 2020";
        $journal->save();

        $journal = new Journal();
        $journal->title_uz = "Iqtisodiyot: tahlillar va prognozlar №3-4 (6-7)";
        $journal->title_ru = "Экономика: анализ и прогнозы №3-4 (6-7)";
        $journal->title_en = "Economics: analysis and forecasts №3-4 (6-7)";
        $journal->image   = "2.jpg";
        $journal->journal = "2.pdf";
        $journal->time_uz = "№3-4 (6-6)2020 yil Mart-Aprel";
        $journal->time_ru = "№3-4 (6-6)Март-Апрель 2020";
        $journal->time_en = "№3-4 (6-6)March-April 2020";
        $journal->save();
    }
}
