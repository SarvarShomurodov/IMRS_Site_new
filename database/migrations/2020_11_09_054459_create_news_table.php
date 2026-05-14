<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title_uz');
            $table->string('title_ru');
            $table->string('title_en');
            $table->string('image_uz')->nullable();
            $table->string('image_ru')->nullable();
            $table->string('image_en')->nullable();
            $table->text('description_uz')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->string('pdf_uz')->nullable();
            $table->string('pdf_ru')->nullable();
            $table->string('pdf_en')->nullable();
            $table->string('video_uz')->nullable();
            $table->string('video_ru')->nullable();
            $table->string('video_en')->nullable();
            $table->integer('views')->nullable();
            $table->string('slug')->unique();
            $table->string('meta_description_uz')->nullable();
            $table->string('meta_description_ru')->nullable();
            $table->string('meta_description_en')->nullable();
            $table->string('meta_keywords_uz')->nullable();
            $table->string('meta_keywords_ru')->nullable();
            $table->string('meta_keywords_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
