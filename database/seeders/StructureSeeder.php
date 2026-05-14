<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Structure;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $structure = new Structure();
        $structure->title_uz  = 'Director';
        $structure->title_ru  = 'Директор';
        $structure->title_en  = 'Director';
        $structure->is_parent = 'yes';
        $structure->sort = '1';
        $structure->type = '2';
        $structure->save();

        $structure = new Structure();
        $structure->title_uz  = 'Ilmiy kengash';
        $structure->title_ru  = 'Ученый совет';
        $structure->title_en  = 'Academic Council';
        $structure->is_parent = 'yes';
        $structure->sort = '2';
        $structure->type = '2';
        $structure->save();

        $structure = new Structure();
        $structure->title_uz = "Direktorning birinchi o'rinbosari";
        $structure->title_ru = 'Первый заместитель директора';
        $structure->title_en = 'First Deputy Director';
        $structure->column   = '1';
        $structure->sort = '3';
        $structure->type = '1';
        $structure->save();

        $structure = new Structure();
        $structure->title_uz = "Test";
        $structure->title_ru = 'Тест';
        $structure->title_en = 'Test';
        $structure->column   = '3';
        $structure->sort = '1';
        $structure->type = '1';
        $structure->save();

    }
}
