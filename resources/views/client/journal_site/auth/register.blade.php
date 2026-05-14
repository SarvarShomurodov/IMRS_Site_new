@extends('client.journal_site.layouts.auth')

@section('title', __('journal.auth.register_title') . ' — IMRS Journal')

@section('content')

<div class="jsite-auth-grid">

  <!-- ── LEFT: Form ── -->
  <section class="jsite-auth-form-side">
    <div class="jsite-auth-form-wrap jsite-auth-form-wide">

      <header class="jsite-auth-head">
        <p class="jsite-auth-eyebrow">@lang('journal.register')</p>
        <h1 class="jsite-auth-title">@lang('journal.auth.register_title')</h1>
        <p class="jsite-auth-sub">@lang('journal.auth.register_sub')</p>
      </header>

      @if (session('error'))
        <div class="jsite-alert jsite-alert-err">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('journal.auth.register.post') }}" class="jsite-auth-form" novalidate>
        @csrf

        <!-- ── FIO ── -->
        <div class="jsite-row-3">

          <div class="jsite-field @error('last_name') has-err @enderror">
            <label for="last_name">@lang('journal.auth.last_name') <span class="req">*</span></label>
            <div class="jsite-input">
              <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="@lang('journal.auth.last_name_ph')" autocomplete="family-name" required>
            </div>
            @error('last_name')<p class="jsite-err">{{ $message }}</p>@enderror
          </div>

          <div class="jsite-field @error('first_name') has-err @enderror">
            <label for="first_name">@lang('journal.auth.first_name') <span class="req">*</span></label>
            <div class="jsite-input">
              <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="@lang('journal.auth.first_name_ph')" autocomplete="given-name" required>
            </div>
            @error('first_name')<p class="jsite-err">{{ $message }}</p>@enderror
          </div>

          <div class="jsite-field @error('middle_name') has-err @enderror">
            <label for="middle_name">@lang('journal.auth.middle_name') <span class="opt">@lang('journal.optional')</span></label>
            <div class="jsite-input">
              <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" placeholder="@lang('journal.auth.middle_name_ph')" autocomplete="additional-name">
            </div>
            @error('middle_name')<p class="jsite-err">{{ $message }}</p>@enderror
          </div>

        </div>

        <!-- ── Email + Phone ── -->
        <div class="jsite-row-2">

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

          <div class="jsite-field @error('phone') has-err @enderror">
            <label for="phone">@lang('journal.auth.phone') <span class="req">*</span></label>
            <div class="jsite-input">
              <span class="jsite-input-ico">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              </span>
              <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="@lang('journal.auth.phone_ph')" data-mask-phone autocomplete="tel" required>
            </div>
            @error('phone')<p class="jsite-err">{{ $message }}</p>@enderror
          </div>

        </div>

        <!-- ── Workplace ── -->
        <div class="jsite-field @error('workplace') has-err @enderror">
          <label for="workplace">@lang('journal.auth.workplace') <span class="opt">@lang('journal.optional')</span></label>
          <div class="jsite-input">
            <span class="jsite-input-ico">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </span>
            <input type="text" id="workplace" name="workplace" value="{{ old('workplace') }}" placeholder="@lang('journal.auth.workplace_ph')" autocomplete="organization">
          </div>
          @error('workplace')<p class="jsite-err">{{ $message }}</p>@enderror
        </div>

        <!-- ── Passwords ── -->
        <div class="jsite-row-2">

          <div class="jsite-field @error('password') has-err @enderror">
            <label for="password">@lang('journal.auth.password') <span class="req">*</span></label>
            <div class="jsite-input">
              <span class="jsite-input-ico">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              </span>
              <input type="password" id="password" name="password" placeholder="@lang('journal.auth.password_ph')" autocomplete="new-password" required>
              <button type="button" class="jsite-input-toggle" data-toggle-pass="#password" aria-label="Show/hide">
                <svg class="ico-eye" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg class="ico-eye-off" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
              </button>
            </div>
            @error('password')<p class="jsite-err">{{ $message }}</p>@enderror
          </div>

          <div class="jsite-field">
            <label for="password_confirmation">@lang('journal.auth.password_confirm') <span class="req">*</span></label>
            <div class="jsite-input">
              <span class="jsite-input-ico">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              </span>
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="@lang('journal.auth.password_ph')" autocomplete="new-password" required>
              <button type="button" class="jsite-input-toggle" data-toggle-pass="#password_confirmation" aria-label="Show/hide">
                <svg class="ico-eye" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg class="ico-eye-off" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
              </button>
            </div>
          </div>

        </div>

        <!-- ── Agree ── -->
        <div class="jsite-field @error('agree') has-err @enderror">
          <label class="jsite-check">
            <input type="checkbox" name="agree" value="1" {{ old('agree') ? 'checked' : '' }} required>
            <span class="jsite-check-box" aria-hidden="true"></span>
            <span class="jsite-check-lbl">@lang('journal.auth.agree')</span>
          </label>
          @error('agree')<p class="jsite-err">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="jsite-btn-primary jsite-btn-block">
          <span>@lang('journal.auth.register_btn')</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>

        <p class="jsite-auth-foot">
          @lang('journal.auth.already_account')
          <a href="{{ route('journal.auth.login') }}" class="jsite-link">@lang('journal.auth.go_login')</a>
        </p>

      </form>

    </div>
  </section>

  <!-- ── RIGHT: Visual side ── -->
  <aside class="jsite-auth-visual" aria-hidden="true">
    <div class="jsite-auth-visual-inner">
      <p class="jsite-auth-v-eyebrow">IMRS · Journal</p>
      <h2 class="jsite-auth-v-title">
        <em>Hamjamiyat</em>ga<br>qo'shiling
      </h2>
      <p class="jsite-auth-v-sub">Iqtisodchilar, moliyachilar va tadqiqotchilar uchun ochiq peer-review platformasi.</p>

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
