@extends('client.journal_site.reviewer._layout')

@section('title', __('journal.rev.dashboard') . ' — IMRS Journal')

@section('panel')

@include('client.journal_site.partials._dashboard-hero', [
  'heroEyebrow' => __('journal.cab.welcome') . ', ' . $user->shortName(),
  'heroTitle'   => __('journal.rev.panel'),
  'heroBadge'   => __('journal.auth.role_reviewer'),
  'heroBadgeIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><polyline points="9 14 11 16 15 12"/></svg>',
])

{{-- Quick actions --}}
<div class="jsite-cab-quick">
  <a href="{{ route('journal.reviewer.inbox') }}" class="jsite-cab-quick-btn is-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
    <span>@lang('journal.rev.inbox_title')</span>
  </a>
  <a href="{{ route('journal.reviewer.completed') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    <span>@lang('journal.rev.completed')</span>
  </a>
  <a href="{{ route('journal.reviewer.all') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    <span>@lang('journal.rev.all_articles')</span>
  </a>
</div>

{{-- Stats --}}
<div class="jsite-cab-stats">
  <a href="{{ route('journal.reviewer.inbox') }}" class="jsite-cab-stat is-warn-link">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['pending'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.rev.stat_pending')</span>
  </a>

  <a href="{{ route('journal.reviewer.completed') }}" class="jsite-cab-stat is-success">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['completed'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.rev.stat_completed')</span>
  </a>

  <div class="jsite-cab-stat">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['total'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.rev.stat_total')</span>
  </div>

  <div class="jsite-cab-stat is-info">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['avg_score'] !== null ? number_format($stats['avg_score'], 2) : '—' }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.rev.stat_avg_score')</span>
  </div>
</div>

<section class="jsite-cab-block">
  <header class="jsite-cab-block-head">
    <h2 class="jsite-cab-block-title jsite-cab-block-title-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      <span>@lang('journal.rev.inbox_title')</span>
    </h2>
    @if ($recentInbox->count() > 0)
      <a href="{{ route('journal.reviewer.inbox') }}" class="jsite-link">
        <span>@lang('journal.cab.view')</span>
        <span aria-hidden="true">→</span>
      </a>
    @endif
  </header>

  @if ($recentInbox->isEmpty())
    <div class="jsite-cab-empty">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      <h3>@lang('journal.rev.no_inbox')</h3>
    </div>
  @else
    <ul class="jsite-cab-articles">
      @foreach ($recentInbox as $a)
        <li class="jsite-cab-article">
          <a href="{{ route('journal.reviewer.article', $a->id) }}" class="jsite-cab-article-row">
            <div class="jsite-cab-article-body">
              <h3 class="jsite-cab-article-title">{{ $a->title_orig }}</h3>
              <div class="jsite-cab-article-meta">
                <span>{{ $a->author->fullName() }}</span>
                <span class="jsite-cab-dot">·</span>
                <time>{{ $a->updated_at->diffForHumans() }}</time>
              </div>
            </div>
            <span class="jsite-status-badge is-warn">
              <span class="jsite-status-text">@lang('journal.mod.reviewer_status_pending')</span>
            </span>
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</section>

<div class="jsite-rev-notice">
  <strong>@lang('journal.rev.anonymous_notice')</strong>
</div>

@endsection
