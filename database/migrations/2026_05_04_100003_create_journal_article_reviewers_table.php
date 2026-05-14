<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Moderator tanlagan taqrizchilar (1..3 ta) — pivot
        Schema::create('journal_article_reviewers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('journal_articles')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('journal_users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamps();

            $table->unique(['article_id', 'reviewer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_article_reviewers');
    }
};
