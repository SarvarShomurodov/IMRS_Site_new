<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalGuest
{
    /**
     * Allaqachon login qilgan foydalanuvchini login/register sahifalariga
     * kiritmaslik — kabinetga yo'naltirish.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('journal')->check()) {
            return redirect()->route('journal.cabinet');
        }

        return $next($request);
    }
}
