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
        Schema::create('scholars', function (Blueprint $table) {
            $table->id();
            $table->string('name_uz');
            $table->string('name_ru');
            $table->string('name_en');
            $table->text('theme_uz');
            $table->text('theme_ru');
            $table->text('theme_en');
            $table->string('phddsc_uz');
            $table->string('phddsc_ru');
            $table->string('phddsc_en');
            $table->string('image');
            $table->string('place_uz');
            $table->string('place_ru');
            $table->string('place_en');
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
        Schema::dropIfExists('scholars');
    }
};
