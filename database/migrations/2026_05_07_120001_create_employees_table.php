<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // Full name (Ism Familya Otachestvo) per locale
            $table->string('name_uz')->nullable();
            $table->string('name_ru')->nullable();
            $table->string('name_en')->nullable();
            // Position (lavozim)
            $table->string('position_uz');
            $table->string('position_ru');
            $table->string('position_en');
            // Project / department name (loyiha / bo'lim nomi)
            $table->string('project_uz');
            $table->string('project_ru');
            $table->string('project_en');
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            // Self-referencing: NULL = team head shown on listing; otherwise = belongs to a head's team
            $table->unsignedBigInteger('head_id')->nullable();
            // Vacant slot
            $table->boolean('is_vacant')->default(false);
            $table->integer('sort')->default(0);
            $table->timestamps();

            $table->foreign('head_id')->references('id')->on('employees')->nullOnDelete();
            $table->index('head_id');
            $table->index('sort');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
