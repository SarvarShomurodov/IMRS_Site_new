<?php

namespace App\Http\Controllers\JournalSite;

use App\Http\Controllers\Controller;
use App\Models\JournalUser;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /* ── Users list (filter, search) ─────────────────────────── */

    public function users(Request $request)
    {
        $q    = trim((string) $request->input('q'));
        $role = (string) $request->input('role');

        $users = JournalUser::query()
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('first_name', 'like', "%{$q}%")
                      ->orWhere('last_name', 'like', "%{$q}%")
                      ->orWhere('middle_name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->when($role !== '' && in_array($role, [
                JournalUser::ROLE_USER,
                JournalUser::ROLE_TECHNIC,
                JournalUser::ROLE_MODERATOR,
                JournalUser::ROLE_REVIEWER,
                JournalUser::ROLE_SUPERADMIN,
            ], true), fn ($qb) => $qb->where('role', $role))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $roleCounts = JournalUser::query()
            ->selectRaw('role, COUNT(*) as cnt')
            ->groupBy('role')
            ->pluck('cnt', 'role');

        return view('client.journal_site.admin.users', [
            'users'      => $users,
            'q'          => $q,
            'role'       => $role,
            'roleCounts' => $roleCounts,
        ]);
    }

    /* ── Role update ─────────────────────────────────────────── */

    public function updateRole(Request $request, JournalUser $user)
    {
        $data = $request->validate([
            'role' => ['required', 'in:'.implode(',', JournalUser::ASSIGNABLE_ROLES)],
        ]);

        // SuperAdmin'ning rolini boshqa rolga o'zgartirib bo'lmaydi
        if ($user->isSuperAdmin()) {
            return back()->with('error', __('journal.admin.cannot_modify_superadmin'));
        }

        // Va boshqa userni superadmin'ga aylantirib ham bo'lmaydi (ASSIGNABLE_ROLES da yo'q)
        $user->update(['role' => $data['role']]);

        return back()->with('success', __('journal.admin.role_updated', [
            'name' => $user->fullName(),
            'role' => __('journal.auth.role_'.$data['role']),
        ]));
    }
}
