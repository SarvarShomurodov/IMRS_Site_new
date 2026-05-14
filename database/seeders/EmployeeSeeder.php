<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        Employee::query()->delete();

        // ───────── LEADER 1: Mehnat unumdorligi (Labour productivity) ─────────
        $leader1 = Employee::create([
            'name_uz'     => 'Sarvar Shamurotov',
            'name_ru'     => 'Сарвар Шамуротов',
            'name_en'     => 'Sarvar Shamurotov',
            'position_uz' => 'Loyiha rahbari',
            'position_ru' => 'Руководитель проекта',
            'position_en' => 'Project Leader',
            'project_uz'  => 'Mehnat unumdorligi',
            'project_ru'  => 'Производительность труда',
            'project_en'  => 'Labour Productivity',
            'email'       => 'sarvar9818sh@gmail.com',
            'head_id'     => null,
            'is_vacant'   => false,
            'sort'        => 10,
        ]);

        Employee::create([
            'name_uz'     => 'Madina Karimova',
            'name_ru'     => 'Мадина Каримова',
            'name_en'     => 'Madina Karimova',
            'position_uz' => 'Katta ilmiy xodim',
            'position_ru' => 'Старший научный сотрудник',
            'position_en' => 'Senior Research Fellow',
            'project_uz'  => 'Mehnat unumdorligi',
            'project_ru'  => 'Производительность труда',
            'project_en'  => 'Labour Productivity',
            'email'       => 'karimovamadina2305@gmail.com',
            'head_id'     => $leader1->id,
            'is_vacant'   => false,
            'sort'        => 10,
        ]);

        Employee::create([
            'name_uz'     => 'Rustam Ibragimov',
            'name_ru'     => 'Рустам Ибрагимов',
            'name_en'     => 'Rustam Ibragimov',
            'position_uz' => 'Ilmiy xodim',
            'position_ru' => 'Научный сотрудник',
            'position_en' => 'Research Fellow',
            'project_uz'  => 'Mehnat unumdorligi',
            'project_ru'  => 'Производительность труда',
            'project_en'  => 'Labour Productivity',
            'email'       => 'r.ibragimov@imrs.uz',
            'head_id'     => $leader1->id,
            'is_vacant'   => false,
            'sort'        => 20,
        ]);

        // ───────── LEADER 2: Makroiqtisodiyot (Macroeconomics) ─────────
        $leader2 = Employee::create([
            'name_uz'     => 'Anvar Yusupov',
            'name_ru'     => 'Анвар Юсупов',
            'name_en'     => 'Anvar Yusupov',
            'position_uz' => "Bo'lim boshlig'i",
            'position_ru' => 'Заведующий отделом',
            'position_en' => 'Head of Department',
            'project_uz'  => 'Makroiqtisodiy tahlil va prognozlashtirish',
            'project_ru'  => 'Макроэкономический анализ и прогнозирование',
            'project_en'  => 'Macroeconomic Analysis and Forecasting',
            'email'       => 'a.yusupov@imrs.uz',
            'head_id'     => null,
            'is_vacant'   => false,
            'sort'        => 20,
        ]);

        Employee::create([
            'name_uz'     => 'Dilshod Tursunov',
            'name_ru'     => 'Дилшод Турсунов',
            'name_en'     => 'Dilshod Tursunov',
            'position_uz' => 'Yetakchi ilmiy xodim',
            'position_ru' => 'Ведущий научный сотрудник',
            'position_en' => 'Leading Research Fellow',
            'project_uz'  => 'Makroiqtisodiy tahlil va prognozlashtirish',
            'project_ru'  => 'Макроэкономический анализ и прогнозирование',
            'project_en'  => 'Macroeconomic Analysis and Forecasting',
            'email'       => 'd.tursunov@imrs.uz',
            'head_id'     => $leader2->id,
            'is_vacant'   => false,
            'sort'        => 10,
        ]);

        Employee::create([
            'name_uz'     => 'Nigora Abdullayeva',
            'name_ru'     => 'Нигора Абдуллаева',
            'name_en'     => 'Nigora Abdullaeva',
            'position_uz' => 'Katta ilmiy xodim',
            'position_ru' => 'Старший научный сотрудник',
            'position_en' => 'Senior Research Fellow',
            'project_uz'  => 'Makroiqtisodiy tahlil va prognozlashtirish',
            'project_ru'  => 'Макроэкономический анализ и прогнозирование',
            'project_en'  => 'Macroeconomic Analysis and Forecasting',
            'email'       => 'n.abdullaeva@imrs.uz',
            'head_id'     => $leader2->id,
            'is_vacant'   => false,
            'sort'        => 20,
        ]);

        Employee::create([
            'name_uz'     => null,
            'name_ru'     => null,
            'name_en'     => null,
            'position_uz' => 'Ilmiy xodim',
            'position_ru' => 'Научный сотрудник',
            'position_en' => 'Research Fellow',
            'project_uz'  => 'Makroiqtisodiy tahlil va prognozlashtirish',
            'project_ru'  => 'Макроэкономический анализ и прогнозирование',
            'project_en'  => 'Macroeconomic Analysis and Forecasting',
            'email'       => null,
            'head_id'     => $leader2->id,
            'is_vacant'   => true,
            'sort'        => 30,
        ]);

        // ───────── LEADER 3: Investitsiyalar (Investment) ─────────
        $leader3 = Employee::create([
            'name_uz'     => 'Bekzod Rahimov',
            'name_ru'     => 'Бекзод Рахимов',
            'name_en'     => 'Bekzod Rakhimov',
            'position_uz' => 'Loyiha rahbari',
            'position_ru' => 'Руководитель проекта',
            'position_en' => 'Project Leader',
            'project_uz'  => 'Investitsion muhit va tashqi savdo',
            'project_ru'  => 'Инвестиционный климат и внешняя торговля',
            'project_en'  => 'Investment Climate and Foreign Trade',
            'email'       => 'b.rakhimov@imrs.uz',
            'head_id'     => null,
            'is_vacant'   => false,
            'sort'        => 30,
        ]);

        Employee::create([
            'name_uz'     => 'Aziza Saidova',
            'name_ru'     => 'Азиза Саидова',
            'name_en'     => 'Aziza Saidova',
            'position_uz' => 'Katta ilmiy xodim',
            'position_ru' => 'Старший научный сотрудник',
            'position_en' => 'Senior Research Fellow',
            'project_uz'  => 'Investitsion muhit va tashqi savdo',
            'project_ru'  => 'Инвестиционный климат и внешняя торговля',
            'project_en'  => 'Investment Climate and Foreign Trade',
            'email'       => 'a.saidova@imrs.uz',
            'head_id'     => $leader3->id,
            'is_vacant'   => false,
            'sort'        => 10,
        ]);

        // ───────── LEADER 4: Vacant slot (no current head) ─────────
        Employee::create([
            'name_uz'     => null,
            'name_ru'     => null,
            'name_en'     => null,
            'position_uz' => "Bo'lim boshlig'i",
            'position_ru' => 'Заведующий отделом',
            'position_en' => 'Head of Department',
            'project_uz'  => 'Hududiy iqtisodiyot',
            'project_ru'  => 'Региональная экономика',
            'project_en'  => 'Regional Economy',
            'email'       => null,
            'head_id'     => null,
            'is_vacant'   => true,
            'sort'        => 40,
        ]);
    }
}
