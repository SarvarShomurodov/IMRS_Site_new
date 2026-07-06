<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('page_heroes', function (Blueprint $table) {
            $table->string('position')->default('center')->after('image');
        });
    }

    public function down()
    {
        Schema::table('page_heroes', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
