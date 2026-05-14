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
        Schema::create('publications_category', function (Blueprint $table) {
            $table->bigInteger('publication_id')->unsigned();
            $table->bigInteger('publication_category_id')->unsigned();
            $table->foreign('publication_id')->references('id')->on('publications');
            $table->foreign('publication_category_id')->references('id')->on('publication_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications_category');
    }
};
