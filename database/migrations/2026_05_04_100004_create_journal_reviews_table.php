<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Taqrizchilarning baholari (rasmdagi 7 mezon)
        Schema::create('journal_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('journal_articles')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('journal_users')->cascadeOnDelete();

            // 7 mezon — har biri 2..5 (2=qoniqarsiz, 3=qoniqarli, 4=yaxshi, 5=a'lo)
            $table->unsignedTinyInteger('score_research_name')->nullable();        // Tadqiqotning nomi
            $table->unsignedTinyInteger('score_topic_relevance')->nullable();      // Tadqiqot mavzusining dolzarbligi
            $table->unsignedTinyInteger('score_problem_analysis')->nullable();     // Mavzu va muammoli holatning tahlili
            $table->unsignedTinyInteger('score_problem_solutions')->nullable();    // Muammolar va ularni hal qilish yo'llari
            $table->unsignedTinyInteger('score_recommendations')->nullable();      // Tavsiyalarning asoslanganligi
            $table->unsignedTinyInteger('score_originality')->nullable();          // Originallik, yangilik va amaliy qo'llash
            $table->unsignedTinyInteger('score_clarity')->nullable();              // Aniq va ravon bayon

            // Yakuniy qaror
            $table->enum('decision', [
                'accept_no_review',     // Qayta ko'rib chiqmasdan qabul qilinsin
                'accept_with_review',   // Qayta ko'rib chiqish talab etiladi
                'reject',               // Rad etilsin
            ]);

            $table->text('comment')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            $table->unique(['article_id', 'reviewer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_reviews');
    }
};
