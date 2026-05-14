@extends('client.journal_site.technic._layout')

@section('title', __('journal.tec.dashboard') . ' — IMRS Journal')

@section('panel')

@include('client.journal_site.partials._dashboard-hero', [
  'heroEyebrow' => __('journal.cab.welcome') . ', ' . $user->shortName(),
  'heroTitle'   => __('journal.tec.panel'),
  'heroBadge'   => __('journal.auth.role_technic'),
  'heroBadgeIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
])

{{-- Quick actions --}}
<div class="jsite-cab-quick">
  <a href="{{ route('journal.technic.inbox') }}" class="jsite-cab-quick-btn is-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
    <span>@lang('journal.tec.inbox')</span>
  </a>
  <a href="{{ route('journal.technic.publish_queue') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
    <span>@lang('journal.tec.publish_queue')</span>
  </a>
  <a href="{{ route('journal.technic.all') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
    <span>@lang('journal.tec.all_articles')</span>
  </a>
</div>

{{-- Stats --}}
<div class="jsite-cab-stats">
  <a href="{{ route('journal.technic.inbox') }}" class="jsite-cab-stat is-warn-link">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['inbox'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.tec.stat_inbox')</span>
  </a>

  <a href="{{ route('journal.technic.publish_queue') }}" class="jsite-cab-stat is-success">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['publish_ready'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.tec.stat_publish_ready')</span>
  </a>

  <div class="jsite-cab-stat is-info">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['in_review'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.tec.stat_in_review')</span>
  </div>

  <div class="jsite-cab-stat">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['total'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.tec.stat_total')</span>
  </div>
</div>

{{-- Recent inbox --}}
<section class="jsite-cab-block">
  <header class="jsite-cab-block-head">
    <h2 class="jsite-cab-block-title jsite-cab-block-title-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
      <span>@lang('journal.tec.inbox')</span>
    </h2>
    @if ($recentInbox->count() > 0)
      <a href="{{ route('journal.technic.inbox') }}" class="jsite-link">
        <span>@lang('journal.cab.view')</span>
        <span aria-hidden="true">→</span>
      </a>
    @endif
  </header>

  @if ($recentInbox->isEmpty())
    <div class="jsite-cab-empty">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
      <h3>@lang('journal.tec.no_inbox')</h3>
      <p>@lang('journal.tec.no_inbox_sub')</p>
    </div>
  @else
    <ul class="jsite-cab-articles">
      @foreach ($recentInbox as $a)
        <li class="jsite-cab-article">
          <a href="{{ route('journal.technic.article', $a->id) }}" class="jsite-cab-article-row">
            <div class="jsite-cab-article-body">
              <h3 class="jsite-cab-article-title">{{ $a->title_orig }}</h3>
              <div class="jsite-cab-article-meta">
                <span>{{ $a->author->fullName() }}</span>
                <span class="jsite-cab-dot">·</span>
                <time>{{ $a->created_at->diffForHumans() }}</time>
              </div>
            </div>
            @include('client.journal_site.components.status-badge', ['status' => $a->status])
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</section>

{{-- Publish queue preview --}}
<section class="jsite-cab-block">
  <header class="jsite-cab-block-head">
    <h2 class="jsite-cab-block-title jsite-cab-block-title-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
      <span>@lang('journal.tec.publish_queue')</span>
    </h2>
    @if ($recentPublishQueue->count() > 0)
      <a href="{{ route('journal.technic.publish_queue') }}" class="jsite-link">
        <span>@lang('journal.cab.view')</span>
        <span aria-hidden="true">→</span>
      </a>
    @endif
  </header>

  @if ($recentPublishQueue->isEmpty())
    <div class="jsite-cab-empty">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
      <h3>@lang('journal.tec.no_publish_queue')</h3>
    </div>
  @else
    <ul class="jsite-cab-articles">
      @foreach ($recentPublishQueue as $a)
        <li class="jsite-cab-article">
          <a href="{{ route('journal.technic.article', $a->id) }}" class="jsite-cab-article-row">
            <div class="jsite-cab-article-body">
              <h3 class="jsite-cab-article-title">{{ $a->title_orig }}</h3>
              <div class="jsite-cab-article-meta">
                <span>{{ $a->author->fullName() }}</span>
                @if ($a->category)
                  <span class="jsite-cab-dot">·</span>
                  <span class="jsite-cab-cat-pill">{{ $a->category }}</span>
                @endif
              </div>
            </div>
            @include('client.journal_site.components.status-badge', ['status' => $a->status])
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</section>

@endsection
