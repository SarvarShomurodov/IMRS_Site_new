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
        Schema::create('publication_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title_uz');
            $table->string('title_ru');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->bigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('publication_categories');
    }
};
