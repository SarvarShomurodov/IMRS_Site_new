<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Audit log — kim qachon nima qildi (statusni o'zgartirdi va h.k.)
        Schema::create('journal_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('journal_articles')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('journal_users')->nullOnDelete();
            $table->string('action');          // submitted, technic_approved, technic_rejected, ...
            $table->string('from_status')->nullable();
            $table->string('to_status')->nullable();
            $table->text('comment')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();

            $table->index('article_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_history');
    }
};
