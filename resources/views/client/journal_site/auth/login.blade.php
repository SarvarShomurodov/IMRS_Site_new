@extends('client.journal_site.layouts.auth')

@section('title', __('journal.auth.login_title') . ' — IMRS Journal')

@section('content')

<div class="jsite-auth-grid">

  <!-- ── LEFT: Form ── -->
  <section class="jsite-auth-form-side">
    <div class="jsite-auth-form-wrap">

      <header class="jsite-auth-head">
        <p class="jsite-auth-eyebrow">@lang('journal.login')</p>
        <h1 class="jsite-auth-title">@lang('journal.auth.login_title')</h1>
        <p class="jsite-auth-sub">@lang('journal.auth.login_sub')</p>
      </header>

      @if (session('success'))
        <div class="jsite-alert jsite-alert-ok">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="jsite-alert jsite-alert-err">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('journal.auth.login.post') }}" class="jsite-auth-form" novalidate>
        @csrf

        <div class="jsite-field @error('email') has-err @enderror">
          <label for="email">@lang('journal.auth.email') <span class="req">*</span></label>
          <div class="jsite-input">
            <span class="jsite-input-ico">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </span>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="@lang('journal.auth.email_ph')" autocomplete="email" required>
          </div>
          @error('email')<p class="jsite-err">{{ $message }}</p>@enderror
        </div>

        <div class="jsite-field @error('password') has-err @enderror">
          <label for="password">@lang('journal.auth.password') <span class="req">*</span></label>
          <div class="jsite-input">
            <span class="jsite-input-ico">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </span>
            <input type="password" id="password" name="password" placeholder="@lang('journal.auth.password_ph')" autocomplete="current-password" required>
            <button type="button" class="jsite-input-toggle" data-toggle-pass="#password" aria-label="Show/hide">
              <svg class="ico-eye" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              <svg class="ico-eye-off" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
            </button>
          </div>
          @error('password')<p class="jsite-err">{{ $message }}</p>@enderror
        </div>

        <div class="jsite-field-row">
          <label class="jsite-check">
            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
            <span class="jsite-check-box" aria-hidden="true"></span>
            <span class="jsite-check-lbl">@lang('journal.auth.remember_me')</span>
          </label>
          <a href="#" class="jsite-link-soft">@lang('journal.auth.forgot_password')</a>
        </div>

        <button type="submit" class="jsite-btn-primary jsite-btn-block">
          <span>@lang('journal.auth.login_btn')</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>

        <p class="jsite-auth-foot">
          @lang('journal.auth.no_account')
          <a href="{{ route('journal.auth.register') }}" class="jsite-link">@lang('journal.auth.create_account')</a>
        </p>

      </form>

    </div>
  </section>

  <!-- ── RIGHT: Visual side ── -->
  <aside class="jsite-auth-visual" aria-hidden="true">
    <div class="jsite-auth-visual-inner">
      <p class="jsite-auth-v-eyebrow">IMRS · Journal</p>
      <h2 class="jsite-auth-v-title">
        Iqtisodiy <em>tafakkur</em> uchun yangi <em>forum</em>
      </h2>
      <p class="jsite-auth-v-sub">Markaziy Osiyo iqtisodchilari, moliyachilari va tadqiqotchilari uchun ochiq retsenziyali jurnal.</p>

      <ul class="jsite-auth-v-stats">
        <li><strong>250+</strong><span>maqola</span></li>
        <li><strong>40+</strong><span>taqrizchi</span></li>
        <li><strong>3</strong><span>til</span></li>
      </ul>

      <div class="jsite-auth-v-mark">
        <span>№</span>
        <b>04</b>
      </div>
    </div>
  </aside>

</div>

@endsection
