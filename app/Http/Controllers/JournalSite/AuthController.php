<?php

namespace App\Http\Controllers\JournalSite;

use App\Http\Controllers\Controller;
use App\Models\JournalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /* ── LOGIN ──────────────────────────────────────────────── */

    public function showLogin()
    {
        return view('client.journal_site.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = (bool) $request->input('remember', false);

        if (!Auth::guard('journal')->attempt($data, $remember)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => __('journal.auth.bad_credentials')]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('journal.cabinet'));
    }

    /* ── REGISTER ───────────────────────────────────────────── */

    public function showRegister()
    {
        return view('client.journal_site.auth.register');
    }

    public function register(Request $request)
    {
        // Tel raqam: +998 (90) 123-45-67 yoki +998901234567 — normalize qilamiz
        $request->merge([
            'phone' => $this->normalizePhone($request->input('phone')),
        ]);

        $data = $request->validate([
            'last_name'   => ['required', 'string', 'max:120'],
            'first_name'  => ['required', 'string', 'max:120'],
            'middle_name' => ['nullable', 'string', 'max:120'],
            'email'       => ['required', 'email', 'max:255', 'unique:journal_users,email'],
            'password'    => ['required', 'confirmed', Password::min(6)],
            'phone'       => ['required', 'string', 'regex:/^\+998\d{9}$/'],
            'workplace'   => ['nullable', 'string', 'max:255'],
            'agree'       => ['accepted'],
        ], [
            'phone.regex' => __('journal.auth.phone_format'),
            'agree.accepted' => __('journal.auth.must_agree'),
        ]);

        unset($data['agree']);

        $user = JournalUser::create([
            'last_name'   => $data['last_name'],
            'first_name'  => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'email'       => $data['email'],
            'password'    => $data['password'], // model 'hashed' cast qiladi
            'phone'       => $data['phone'],
            'workplace'   => $data['workplace'] ?? null,
            'role'        => JournalUser::ROLE_USER,
        ]);

        Auth::guard('journal')->login($user);
        $request->session()->regenerate();

        return redirect()->route('journal.cabinet')
            ->with('success', __('journal.auth.welcome_registered'));
    }

    /* ── LOGOUT ─────────────────────────────────────────────── */

    public function logout(Request $request)
    {
        $locale = $request->session()->get('locale');

        Auth::guard('journal')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($locale) {
            $request->session()->put('locale', $locale);
        }

        return redirect()->route('journals');
    }

    /* ── HELPERS ────────────────────────────────────────────── */

    /**
     * Tel raqamni normalize qiladi: faqat raqamlarni qoldiradi va +998 prefix qo'shadi.
     */
    private function normalizePhone(?string $value): ?string
    {
        if ($value === null || $value === '') return null;

        $digits = preg_replace('/\D+/', '', $value);

        // Agar 998 bilan boshlansa — old +
        if (str_starts_with($digits, '998')) {
            return '+'.$digits;
        }

        // Agar 9 ta raqam bo'lsa (90 1234567) — +998 qo'shamiz
        if (strlen($digits) === 9) {
            return '+998'.$digits;
        }

        // Boshqa hollarda — 12 ta raqam kerak (998 + 9)
        if (strlen($digits) === 12) {
            return '+'.$digits;
        }

        return $value; // validatsiya rad qiladi
    }
}
