<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('page_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Pre-seed the known page-hero pages so the admin only uploads images.
        $now = now();
        $pages = [
            ['page_key' => 'history',                 'name' => 'История', 'image' => 'TRB01149.JPG'],
            ['page_key' => 'structure',              'name' => 'Структура'],
            ['page_key' => 'administrations',        'name' => 'Руководство'],
            ['page_key' => 'employees',              'name' => 'Сотрудники'],
            ['page_key' => 'protection',             'name' => 'Защита диссертаций'],
            ['page_key' => 'journal',                'name' => 'Журнал (страница)'],
            ['page_key' => 'publications_all',       'name' => 'Все публикации'],
            ['page_key' => 'publication',            'name' => 'Публикация (страница)'],
            ['page_key' => 'publication_categories', 'name' => 'Категории публикаций'],
            ['page_key' => 'page',                   'name' => 'Статическая страница'],
            ['page_key' => 'search',                 'name' => 'Поиск'],
            ['page_key' => 'infographicsbyshashtag', 'name' => 'Инфографика (хэштег)'],
            ['page_key' => 'infographicsitem',       'name' => 'Инфографика (элемент)'],
        ];

        foreach ($pages as $p) {
            DB::table('page_heroes')->insert([
                'page_key'   => $p['page_key'],
                'name'       => $p['name'],
                'image'      => $p['image'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('page_heroes');
    }
};
