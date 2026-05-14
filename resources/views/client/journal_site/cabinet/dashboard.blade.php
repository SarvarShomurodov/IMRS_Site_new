@extends('client.journal_site.cabinet._layout')

@section('title', __('journal.cab.dashboard') . ' — IMRS Journal')

@section('cabinet')

@include('client.journal_site.partials._dashboard-hero', [
  'heroEyebrow' => __('journal.cab.welcome') . ', ' . $user->shortName(),
  'heroTitle'   => __('journal.cab.overview'),
  'heroBadge'   => __('journal.auth.role_user'),
  'heroBadgeIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
])

{{-- Quick actions --}}
<div class="jsite-cab-quick">
  <a href="{{ route('journal.cabinet.submit') }}" class="jsite-cab-quick-btn is-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    <span>@lang('journal.submit_article')</span>
  </a>
  <a href="{{ route('journal.cabinet.articles') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    <span>@lang('journal.cab.my_articles')</span>
  </a>
  <a href="{{ route('journals') }}" class="jsite-cab-quick-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
    <span>@lang('index.journals')</span>
  </a>
</div>

{{-- Stats --}}
<div class="jsite-cab-stats">
  <div class="jsite-cab-stat">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['total'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.cab.stat_total')</span>
  </div>

  <div class="jsite-cab-stat is-info">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['in_review'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.cab.stat_in_review')</span>
  </div>

  <div class="jsite-cab-stat is-success">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['published'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.cab.stat_published')</span>
  </div>

  <div class="jsite-cab-stat is-danger">
    <span class="jsite-cab-stat-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </span>
    <span class="jsite-cab-stat-num">{{ $stats['rejected'] }}</span>
    <span class="jsite-cab-stat-lbl">@lang('journal.cab.stat_rejected')</span>
  </div>
</div>

{{-- Recent --}}
<section class="jsite-cab-block">
  <header class="jsite-cab-block-head">
    <h2 class="jsite-cab-block-title jsite-cab-block-title-ico">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      <span>@lang('journal.cab.my_articles')</span>
    </h2>
    @if ($recent->count() > 0)
      <a href="{{ route('journal.cabinet.articles') }}" class="jsite-link">
        <span>@lang('journal.cab.view')</span>
        <span aria-hidden="true">→</span>
      </a>
    @endif
  </header>

  @if ($recent->isEmpty())
    <div class="jsite-cab-empty">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      <h3>@lang('journal.cab.no_articles')</h3>
      <p>@lang('journal.cab.no_articles_sub')</p>
      <a href="{{ route('journal.cabinet.submit') }}" class="jsite-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>@lang('journal.cab.submit_first')</span>
      </a>
    </div>
  @else
    <ul class="jsite-cab-articles">
      @foreach ($recent as $a)
        <li class="jsite-cab-article">
          <a href="{{ route('journal.cabinet.article', $a->id) }}" class="jsite-cab-article-row">
            <div class="jsite-cab-article-body">
              <h3 class="jsite-cab-article-title">{{ $a->title_orig }}</h3>
              <div class="jsite-cab-article-meta">
                <time>{{ $a->created_at->format('Y-m-d') }}</time>
                <span class="jsite-cab-dot">·</span>
                <span class="jsite-cab-mono">{{ $a->file_original_name }}</span>
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
