@extends('client.journal_site.layouts.app')

@push('head')
<link rel="stylesheet" href="{{ asset('assets/journal/css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('assets/journal/css/cabinet.css') }}">
<link rel="stylesheet" href="{{ asset('assets/journal/css/admin.css') }}">
@endpush

@section('content')

@php
  $panelUser = Auth::guard('journal')->user();

  $inboxCount  = \App\Models\JournalArticle::where('status', 'moderator_assign')->count();
  $reviewCount = \App\Models\JournalArticle::where('status', 'peer_review')->count();
  $finalCount  = \App\Models\JournalArticle::where('status', 'moderator_final')->count();
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
            <span>{{ __('journal.mod.panel') }}</span>
          </div>
        </div>

        <nav class="jsite-cab-nav" aria-label="Moderator">
          <a href="{{ route('journal.moderator.dashboard') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.moderator.dashboard')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span>@lang('journal.mod.dashboard')</span>
          </a>

          <a href="{{ route('journal.moderator.inbox') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.moderator.inbox')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 19a6 6 0 0 0-12 0"/><circle cx="8" cy="9" r="4"/><path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"/></svg>
            <span>@lang('journal.mod.inbox')</span>
            @if ($inboxCount > 0)
              <span class="jsite-cab-nav-badge is-warn">{{ $inboxCount }}</span>
            @endif
          </a>

          <a href="{{ route('journal.moderator.in_review') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.moderator.in_review')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>@lang('journal.mod.in_review')</span>
            @if ($reviewCount > 0)
              <span class="jsite-cab-nav-badge is-purple">{{ $reviewCount }}</span>
            @endif
          </a>

          <a href="{{ route('journal.moderator.final_queue') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.moderator.final_queue')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span>@lang('journal.mod.final_queue')</span>
            @if ($finalCount > 0)
              <span class="jsite-cab-nav-badge is-emerald">{{ $finalCount }}</span>
            @endif
          </a>

          <a href="{{ route('journal.moderator.all') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.moderator.all')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span>@lang('journal.mod.all_articles')</span>
          </a>

          <a href="{{ route('journal.moderator.issues.index') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.moderator.issues.*')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            <span>@lang('journal.mod.issues_nav')</span>
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
