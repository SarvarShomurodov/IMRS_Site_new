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
        Schema::create('administrations', function (Blueprint $table) {
            $table->id();
            $table->string('title_uz');
            $table->string('title_ru');
            $table->string('title_en');
            $table->string('name_uz')->nullable();
            $table->string('name_ru')->nullable();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->enum('vacant', ['yes', 'no'])->default('no');
            $table->text('duties_uz')->nullable();
            $table->text('duties_ru')->nullable();
            $table->text('duties_en')->nullable();
            $table->text('biography_uz')->nullable();
            $table->text('biography_ru')->nullable();
            $table->text('biography_en')->nullable();
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
        Schema::dropIfExists('administrations');
    }
};
