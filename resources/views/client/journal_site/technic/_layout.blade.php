@extends('client.journal_site.layouts.app')

@push('head')
<link rel="stylesheet" href="{{ asset('assets/journal/css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('assets/journal/css/cabinet.css') }}">
<link rel="stylesheet" href="{{ asset('assets/journal/css/admin.css') }}">
@endpush

@section('content')

@php
  $panelUser = Auth::guard('journal')->user();

  $inboxCount   = \App\Models\JournalArticle::where('status', 'technical_review')->count();
  $publishCount = \App\Models\JournalArticle::where('status', 'ready_to_publish')->count();
@endphp

<section class="jsite-cab-sec">
  <div class="jsite-container">
    <div class="jsite-cab-grid">

      {{-- ── Sidebar ── --}}
      <aside class="jsite-cab-side">

        <div class="jsite-cab-user">
          <span class="jsite-cab-avatar">{{ mb_substr($panelUser->first_name, 0, 1) }}{{ mb_substr($panelUser->last_name, 0, 1) }}</span>
          <div class="jsite-cab-user-info">
            <strong>{{ $panelUser->fullName() }}</strong>
            <span>{{ __('journal.tec.panel') }}</span>
          </div>
        </div>

        <nav class="jsite-cab-nav" aria-label="Technic">
          <a href="{{ route('journal.technic.dashboard') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.technic.dashboard')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span>@lang('journal.tec.dashboard')</span>
          </a>

          <a href="{{ route('journal.technic.inbox') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.technic.inbox')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
            <span>@lang('journal.tec.inbox')</span>
            @if ($inboxCount > 0)
              <span class="jsite-cab-nav-badge is-warn">{{ $inboxCount }}</span>
            @endif
          </a>

          <a href="{{ route('journal.technic.publish_queue') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.technic.publish_queue')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <span>@lang('journal.tec.publish_queue')</span>
            @if ($publishCount > 0)
              <span class="jsite-cab-nav-badge is-emerald">{{ $publishCount }}</span>
            @endif
          </a>

          <a href="{{ route('journal.technic.all') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.technic.all')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span>@lang('journal.tec.all_articles')</span>
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

        @yield('panel')
      </main>

    </div>
  </div>
</section>

@endsection
