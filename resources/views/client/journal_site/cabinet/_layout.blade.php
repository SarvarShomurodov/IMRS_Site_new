@extends('client.journal_site.layouts.app')

@push('head')
{{-- Cabinet uses shared form/btn/alert styles from auth.css --}}
<link rel="stylesheet" href="{{ asset('assets/journal/css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('assets/journal/css/cabinet.css') }}">
@endpush

@section('content')

@php $cabUser = Auth::guard('journal')->user(); @endphp

<section class="jsite-cab-sec">
  <div class="jsite-container">
    <div class="jsite-cab-grid">

      {{-- ── Sidebar ── --}}
      <aside class="jsite-cab-side">

        <div class="jsite-cab-user">
          <span class="jsite-cab-avatar">{{ mb_substr($cabUser->first_name, 0, 1) }}{{ mb_substr($cabUser->last_name, 0, 1) }}</span>
          <div class="jsite-cab-user-info">
            <strong>{{ $cabUser->fullName() }}</strong>
            <span>{{ __('journal.auth.role_'.$cabUser->role) }}</span>
          </div>
        </div>

        <nav class="jsite-cab-nav" aria-label="Cabinet">
          <a href="{{ route('journal.cabinet') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.cabinet')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span>@lang('journal.cab.dashboard')</span>
          </a>
          <a href="{{ route('journal.cabinet.articles') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.cabinet.articles') || request()->routeIs('journal.cabinet.article')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span>@lang('journal.cab.my_articles')</span>
          </a>
          <a href="{{ route('journal.cabinet.submit') }}" @class(['jsite-cab-nav-item jsite-cab-nav-cta', 'is-act' => request()->routeIs('journal.cabinet.submit')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span>@lang('journal.cab.submit_new')</span>
          </a>
        </nav>

        <div class="jsite-cab-side-foot">
          <form method="POST" action="{{ route('journal.auth.logout') }}">
            @csrf
            <button type="submit" class="jsite-cab-logout">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              <span>@lang('journal.logout')</span>
            </button>
          </form>
        </div>

      </aside>

      {{-- ── Main ── --}}
      <main class="jsite-cab-main">
        @if (session('success'))
          <div class="jsite-alert jsite-alert-ok">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="jsite-alert jsite-alert-err">{{ session('error') }}</div>
        @endif

        @yield('cabinet')
      </main>

    </div>
  </div>
</section>

@endsection
