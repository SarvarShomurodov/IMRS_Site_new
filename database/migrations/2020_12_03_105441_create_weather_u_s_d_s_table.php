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
        Schema::create('weather_u_s_d_s', function (Blueprint $table) {
            $table->id();
            $table->integer('weather_from')->nullable();
            $table->integer('weather_to')->nullable();
            $table->bigInteger('weather_id')->nullable();
            $table->double('usd_from')->nullable();
            $table->double('usd_to')->nullable();
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
        Schema::dropIfExists('weather_u_s_d_s');
    }
};
