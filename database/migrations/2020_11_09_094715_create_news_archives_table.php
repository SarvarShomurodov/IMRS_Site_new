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
        Schema::create('news_archives', function (Blueprint $table) {
            $table->bigInteger('news_id')->unsigned();
            $table->bigInteger('archive_id')->unsigned();
      			$table->foreign('news_id')->references('id')->on('news');
      			$table->foreign('archive_id')->references('id')->on('archives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_archives');
    }
};
