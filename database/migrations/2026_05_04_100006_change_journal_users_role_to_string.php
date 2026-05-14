<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/*
 * role ustunini ENUM dan VARCHAR ga o'tkazadi —
 * 'superadmin' kabi yangi rollarni qo'shish imkonini beradi.
 *
 * Bu migration agar avval 100001-migration enum bilan ishga tushirilgan bo'lsa
 * uni string'ga o'tkazadi. Yangi loyihalarda ham idempotent — string-string-ga
 * MODIFY hech qanday ta'sir qilmaydi.
 */
return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE journal_users MODIFY role VARCHAR(32) NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE journal_users MODIFY role ENUM('user','technic','moderator','reviewer') NOT NULL DEFAULT 'user'");
    }
};
