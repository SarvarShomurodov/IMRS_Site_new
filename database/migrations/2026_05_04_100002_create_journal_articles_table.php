<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('journal_articles', function (Blueprint $table) {
            $table->id();

            // Author
            $table->foreignId('user_id')->constrained('journal_users')->cascadeOnDelete();

            // Submitted by user
            $table->string('title_orig');                 // User kiritgan dastlabki sarlavha
            $table->string('file_path');                  // Word fayl yo'li (.doc/.docx)
            $table->string('file_original_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            // Workflow status
            // technical_review → moderator_assign → peer_review → moderator_final → ready_to_publish → published
            // har qaysi bosqichdan: rejected
            $table->enum('status', [
                'technical_review',     // Texnikda turibdi
                'technic_rejected',     // Texnik rad etgan
                'moderator_assign',     // Moderator taqrizchilarni tanlamoqda
                'peer_review',          // Taqrizchilarda
                'moderator_final',      // Taqrizlar tugagan, Moderator yakuniy qaror qiladi
                'moderator_rejected',   // Moderator rad etgan
                'ready_to_publish',     // Texnikka publish uchun ketgan
                'published',            // Saytda chiqarilgan
            ])->default('technical_review');

            // Rejection
            $table->text('rejection_reason')->nullable();

            // Workflow ownership
            $table->foreignId('technic_id')->nullable()->constrained('journal_users')->nullOnDelete();
            $table->foreignId('moderator_id')->nullable()->constrained('journal_users')->nullOnDelete();

            // Moderator-assigned taxonomy
            $table->string('category')->nullable();       // AI, Makroiqtisodiyot, Biznes, Yangiliklar...
            $table->json('tags')->nullable();             // hashtaglar massivi

            // Texnik publish bosqichi (saytda ko'rinadigan ma'lumot)
            $table->string('title_publish')->nullable();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->date('publish_date')->nullable();
            $table->unsignedInteger('views')->default(0);

            $table->timestamps();

            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_articles');
    }
};
