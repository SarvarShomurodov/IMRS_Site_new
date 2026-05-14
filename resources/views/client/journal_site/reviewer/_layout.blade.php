@extends('client.journal_site.layouts.app')

@push('head')
<link rel="stylesheet" href="{{ asset('assets/journal/css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('assets/journal/css/cabinet.css') }}">
@endpush

@section('content')

@php
  $panelUser = Auth::guard('journal')->user();

  // Reviewer'ga tayinlangan, hali baholanmagan sanog'i
  $pendingCount = \DB::table('journal_article_reviewers')
      ->where('reviewer_id', $panelUser->id)
      ->where('status', 'pending')
      ->count();

  $completedCount = \App\Models\JournalReview::where('reviewer_id', $panelUser->id)->count();
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
            <span>{{ __('journal.rev.panel') }}</span>
          </div>
        </div>

        <nav class="jsite-cab-nav" aria-label="Reviewer">
          <a href="{{ route('journal.reviewer.dashboard') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.reviewer.dashboard')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span>@lang('journal.rev.dashboard')</span>
          </a>

          <a href="{{ route('journal.reviewer.inbox') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.reviewer.inbox')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><polyline points="9 14 11 16 15 12"/></svg>
            <span>@lang('journal.rev.inbox')</span>
            @if ($pendingCount > 0)
              <span class="jsite-cab-nav-badge is-warn">{{ $pendingCount }}</span>
            @endif
          </a>

          <a href="{{ route('journal.reviewer.completed') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.reviewer.completed')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <span>@lang('journal.rev.completed')</span>
            @if ($completedCount > 0)
              <span class="jsite-cab-nav-badge is-emerald">{{ $completedCount }}</span>
            @endif
          </a>

          <a href="{{ route('journal.reviewer.all') }}" @class(['jsite-cab-nav-item', 'is-act' => request()->routeIs('journal.reviewer.all')])>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span>@lang('journal.rev.all_articles')</span>
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
