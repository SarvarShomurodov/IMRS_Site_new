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
        Schema::create('infographics_hashtags', function (Blueprint $table) {
          $table->bigInteger('infographic_id')->unsigned();
          $table->bigInteger('hashtag_id')->unsigned();
          $table->foreign('infographic_id')->references('id')->on('photo_galleries');
          $table->foreign('hashtag_id')->references('id')->on('hash_tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infographics_hashtags');
    }
};
