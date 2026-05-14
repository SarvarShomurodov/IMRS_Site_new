<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('journal_articles', function (Blueprint $table) {
            $table->unsignedTinyInteger('plagiarism_percent')->nullable()->after('rejection_reason');
        });
    }

    public function down(): void
    {
        Schema::table('journal_articles', function (Blueprint $table) {
            $table->dropColumn('plagiarism_percent');
        });
    }
};
