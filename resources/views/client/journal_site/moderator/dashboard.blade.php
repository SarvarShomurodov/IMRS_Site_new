@extends('client.journal_site.moderator._layout')

@section('title', __('journal.mod.dashboard') . ' — IMRS Journal')

@section('panel')

@include('client.journal_site.partials._dashboard-hero', [
  'heroEyebrow' => __('journal.cab.welcome') . ', ' . $user->shortName(),
  'heroTitle'   => __('journal.mod.panel'),
  'heroBadge'   => __('journal.auth.role_moderator'),
  'heroBadgeIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 19a6 6 0 0 0-12 0"/><circle cx="8" cy="9" r="4"/><path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"/></svg>',
])

{{-- Quick actions --}}
<div class="jsite-cab-quick">
  <a href="{{ route('journal.moderator.inbox') }}" class="jsite-cab-quick-btn is-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
    <span>@lang('journal.mod.inbox')</span>
  </a>
  <a href="{{ route('journal.moderator.in_review') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    <span>@lang('journal.mod.stat_in_review')</span>
  </a>
  <a href="{{ route('journal.moderator.final_queue') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
    <span>@lang('journal.mod.final_queue')</span>
  </a>
  <a href="{{ route('journal.moderator.all') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
    <span>@lang('journal.mod.all_articles')</span>
  </a>
</div>

{{-- Stats --}}
<div class="jsite-cab-stats">
  <a href="{{ route('journal.moderator.inbox') }}" class="jsite-cab-stat is-warn-link">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['inbox'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.mod.stat_inbox')</span>
  </a>

  <a href="{{ route('journal.moderator.in_review') }}" class="jsite-cab-stat is-violet">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['in_review'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.mod.stat_in_review')</span>
  </a>

  <a href="{{ route('journal.moderator.final_queue') }}" class="jsite-cab-stat is-success">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['final'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.mod.stat_final')</span>
  </a>

  <div class="jsite-cab-stat">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['total'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.mod.stat_total')</span>
  </div>
</div>

{{-- Inbox preview --}}
<section class="jsite-cab-block">
  <header class="jsite-cab-block-head">
    <h2 class="jsite-cab-block-title jsite-cab-block-title-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
      <span>@lang('journal.mod.inbox')</span>
    </h2>
    @if ($recentInbox->count() > 0)
      <a href="{{ route('journal.moderator.inbox') }}" class="jsite-link">
        <span>@lang('journal.cab.view')</span>
        <span aria-hidden="true">→</span>
      </a>
    @endif
  </header>

  @if ($recentInbox->isEmpty())
    <div class="jsite-cab-empty">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
      <h3>@lang('journal.mod.no_inbox')</h3>
    </div>
  @else
    <ul class="jsite-cab-articles">
      @foreach ($recentInbox as $a)
        <li class="jsite-cab-article">
          <a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-cab-article-row">
            <div class="jsite-cab-article-body">
              <h3 class="jsite-cab-article-title">{{ $a->title_orig }}</h3>
              <div class="jsite-cab-article-meta">
                <span>{{ $a->author->fullName() }}</span>
                <span class="jsite-cab-dot">·</span>
                <time>{{ $a->updated_at->diffForHumans() }}</time>
              </div>
            </div>
            @include('client.journal_site.components.status-badge', ['status' => $a->status])
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</section>

{{-- Final queue preview --}}
<section class="jsite-cab-block">
  <header class="jsite-cab-block-head">
    <h2 class="jsite-cab-block-title jsite-cab-block-title-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      <span>@lang('journal.mod.final_queue')</span>
    </h2>
    @if ($recentFinal->count() > 0)
      <a href="{{ route('journal.moderator.final_queue') }}" class="jsite-link">
        <span>@lang('journal.cab.view')</span>
        <span aria-hidden="true">→</span>
      </a>
    @endif
  </header>

  @if ($recentFinal->isEmpty())
    <div class="jsite-cab-empty">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      <h3>@lang('journal.mod.no_final_queue')</h3>
    </div>
  @else
    <ul class="jsite-cab-articles">
      @foreach ($recentFinal as $a)
        <li class="jsite-cab-article">
          <a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-cab-article-row">
            <div class="jsite-cab-article-body">
              <h3 class="jsite-cab-article-title">{{ $a->title_orig }}</h3>
              <div class="jsite-cab-article-meta">
                <span>{{ $a->author->fullName() }}</span>
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
