@extends('client.journal_site.layouts.app')

@section('title', __('journal.cabinet') . ' — IMRS Journal')

@section('content')

@php $u = Auth::guard('journal')->user(); @endphp

<section class="jsite-list-sec">
  <div class="jsite-container">

    @if (session('success'))
      <div class="jsite-alert jsite-alert-ok" style="margin-bottom:1.5rem">{{ session('success') }}</div>
    @endif

    <div style="text-align:center; padding: 4rem 0;">
      <h1 class="jsite-hero-title" style="font-size: clamp(1.8rem, 4vw, 3rem);">
        Salom, <em>{{ $u->first_name }}</em>!
      </h1>
      <p style="margin: 1rem 0 2rem; color: var(--t2); font-size: 1rem;">
        Sizning shaxsiy kabinetingiz keyingi bosqichda yaratiladi.<br>
        Hozircha siz <strong>{{ __('journal.auth.role_'.$u->role) }}</strong> rolida tizimga kirgansiz.
      </p>

      <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
        @if ($u->isSuperAdmin())
          <a href="{{ route('journal.admin.users') }}" class="jsite-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            @lang('journal.admin.go_to_admin')
          </a>
        @endif
        @if ($u->isTechnic())
          <a href="{{ route('journal.technic.dashboard') }}" class="jsite-btn-primary">
            @lang('journal.tec.panel') →
          </a>
        @endif
        <a href="{{ route('journals') }}" class="jsite-btn-ghost">
          <span>@lang('journal.back_home')</span>
        </a>
        <form method="POST" action="{{ route('journal.auth.logout') }}" style="display:inline;">
          @csrf
          <button type="submit" class="jsite-btn-ghost">
            @lang('journal.logout')
          </button>
        </form>
      </div>

      <div style="margin-top: 3rem; padding: 1.5rem; background: var(--bg3); border-radius: 8px; max-width: 500px; margin-left:auto; margin-right:auto; text-align:left;">
        <p style="font-size: .82rem; color: var(--t2); margin-bottom: .5rem;"><strong>Profile:</strong></p>
        <p style="font-size: .85rem; margin: .25rem 0;">FIO: {{ $u->fullName() }}</p>
        <p style="font-size: .85rem; margin: .25rem 0;">Email: {{ $u->email }}</p>
        @if ($u->phone)
          <p style="font-size: .85rem; margin: .25rem 0;">Telefon: {{ $u->phone }}</p>
        @endif
        @if ($u->workplace)
          <p style="font-size: .85rem; margin: .25rem 0;">Ish joyi: {{ $u->workplace }}</p>
        @endif
        <p style="font-size: .85rem; margin: .25rem 0;">Rol: <strong>{{ __('journal.auth.role_'.$u->role) }}</strong></p>
      </div>
    </div>

  </div>
</section>

@endsection
