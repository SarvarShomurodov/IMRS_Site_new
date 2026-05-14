<?php

namespace Database\Seeders;

use App\Models\JournalUser;
use Illuminate\Database\Seeder;

class JournalUserSeeder extends Seeder
{
    public function run(): void
    {
        // ── SuperAdmin (alohida — o'z paroli bilan) ──
        JournalUser::updateOrCreate(
            ['email' => 'sarvar9818sh@gmail.com'],
            [
                'last_name'   => 'Shamurotov',
                'first_name'  => 'Sarvar',
                'middle_name' => null,
                'email'       => 'sarvar9818sh@gmail.com',
                'password'    => 'Dekabr1997',
                'phone'       => null,
                'workplace'   => 'IMRS',
                'role'        => JournalUser::ROLE_SUPERADMIN,
            ]
        );

        // Asosiy parol — barcha test userlar uchun bir xil
        $defaultPassword = 'imrs2026';

        $users = [
            // ── Texnik ──
            [
                'last_name'   => 'Texnikov',
                'first_name'  => 'Texnik',
                'middle_name' => 'Texnikovich',
                'email'       => 'texnik@imrs.uz',
                'phone'       => '+998901111111',
                'workplace'   => 'IMRS — Texnik bo\'limi',
                'role'        => JournalUser::ROLE_TECHNIC,
            ],

            // ── Moderator ──
            [
                'last_name'   => 'Moderatov',
                'first_name'  => 'Moder',
                'middle_name' => 'Moderovich',
                'email'       => 'moderator@imrs.uz',
                'phone'       => '+998902222222',
                'workplace'   => 'IMRS — Tahririyat',
                'role'        => JournalUser::ROLE_MODERATOR,
            ],

            // ── Taqrizchilar (3 ta) ──
            [
                'last_name'   => 'Karimov',
                'first_name'  => 'Akmal',
                'middle_name' => 'Sherzodovich',
                'email'       => 'taqrizchi1@imrs.uz',
                'phone'       => '+998903333331',
                'workplace'   => 'O\'zbekiston Iqtisodiyot Akademiyasi',
                'role'        => JournalUser::ROLE_REVIEWER,
            ],
            [
                'last_name'   => 'Yusupova',
                'first_name'  => 'Dilfuza',
                'middle_name' => 'Akbarovna',
                'email'       => 'taqrizchi2@imrs.uz',
                'phone'       => '+998903333332',
                'workplace'   => 'Toshkent Davlat Iqtisodiyot Universiteti',
                'role'        => JournalUser::ROLE_REVIEWER,
            ],
            [
                'last_name'   => 'Mirzayev',
                'first_name'  => 'Sardor',
                'middle_name' => 'Bekzodovich',
                'email'       => 'taqrizchi3@imrs.uz',
                'phone'       => '+998903333333',
                'workplace'   => 'Markaziy bank · Tahliliy bo\'lim',
                'role'        => JournalUser::ROLE_REVIEWER,
            ],

            // ── Oddiy User (muallif) ──
            [
                'last_name'   => 'Aliyev',
                'first_name'  => 'Bekzod',
                'middle_name' => 'Otabekovich',
                'email'       => 'user@imrs.uz',
                'phone'       => '+998904444444',
                'workplace'   => 'TUIT — Yosh tadqiqotchi',
                'role'        => JournalUser::ROLE_USER,
            ],
        ];

        foreach ($users as $u) {
            JournalUser::updateOrCreate(
                ['email' => $u['email']],
                array_merge($u, ['password' => $defaultPassword])
            );
        }

        $this->command?->info('Journal users seeded.');
        $this->command?->info('  SuperAdmin: sarvar9818sh@gmail.com (custom password)');
        $this->command?->info('  Test users default password: '.$defaultPassword);
    }
}
