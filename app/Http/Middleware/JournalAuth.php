<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalAuth
{
    /**
     * Faqat jurnal saytida login qilgan foydalanuvchilarga ruxsat.
     * Agar `roles` parametri berilgan bo'lsa, faqat shu rollar.
     *
     * Misol: ->middleware('journal.auth:moderator')
     *        ->middleware('journal.auth:technic,moderator')
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!Auth::guard('journal')->check()) {
            return redirect()->route('journal.auth.login')
                ->with('error', __('journal.auth.must_login'));
        }

        if (!empty($roles)) {
            $user = Auth::guard('journal')->user();
            if (!in_array($user->role, $roles, true)) {
                abort(403, __('journal.auth.access_denied'));
            }
        }

        return $next($request);
    }
}
