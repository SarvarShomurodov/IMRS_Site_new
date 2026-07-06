<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nashr maydonlarini 3 tilda saqlash uchun ustunlar.
     * Hammasi nullable — texnik bir yoki bir nechta tilda to'ldirishi mumkin.
     * Eski (til neytral) title_publish / description / cover ustunlari
     * fallback sifatida qoldiriladi.
     */
    public function up(): void
    {
        Schema::table('journal_articles', function (Blueprint $table) {
            // Saytda chiqadigan sarlavha
            $table->string('title_publish_uz')->nullable()->after('title_publish');
            $table->string('title_publish_ru')->nullable()->after('title_publish_uz');
            $table->string('title_publish_en')->nullable()->after('title_publish_ru');

            // Tavsif (qisqacha)
            $table->text('description_uz')->nullable()->after('description');
            $table->text('description_ru')->nullable()->after('description_uz');
            $table->text('description_en')->nullable()->after('description_ru');

            // Muqova rasmi
            $table->string('cover_uz')->nullable()->after('cover');
            $table->string('cover_ru')->nullable()->after('cover_uz');
            $table->string('cover_en')->nullable()->after('cover_ru');
        });
    }

    public function down(): void
    {
        Schema::table('journal_articles', function (Blueprint $table) {
            $table->dropColumn([
                'title_publish_uz', 'title_publish_ru', 'title_publish_en',
                'description_uz', 'description_ru', 'description_en',
                'cover_uz', 'cover_ru', 'cover_en',
            ]);
        });
    }
};
