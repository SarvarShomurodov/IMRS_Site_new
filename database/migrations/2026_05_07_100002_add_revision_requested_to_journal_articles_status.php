<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE `journal_articles` MODIFY `status` ENUM(
            'technical_review',
            'technic_rejected',
            'revision_requested',
            'moderator_assign',
            'peer_review',
            'moderator_final',
            'moderator_rejected',
            'ready_to_publish',
            'published'
        ) NOT NULL DEFAULT 'technical_review'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `journal_articles` MODIFY `status` ENUM(
            'technical_review',
            'technic_rejected',
            'moderator_assign',
            'peer_review',
            'moderator_final',
            'moderator_rejected',
            'ready_to_publish',
            'published'
        ) NOT NULL DEFAULT 'technical_review'");
    }
};
