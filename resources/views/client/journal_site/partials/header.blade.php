@php
  $loc = app()->getLocale();
  $jUser = auth('journal')->user();

  // Kategoriyalar va ularning hisobi (published maqolalar bo'yicha)
  $hdrCategories = \App\Http\Controllers\JournalSite\ModeratorController::CATEGORIES;
  $hdrCategoryCounts = \App\Models\JournalArticle::where('status', \App\Models\JournalArticle::ST_PUBLISHED)
    ->selectRaw('category, COUNT(*) as n')
    ->whereNotNull('category')
    ->groupBy('category')
    ->pluck('n', 'category');
  $hdrTotal = (int) $hdrCategoryCounts->sum();
  $hdrActiveCat = request('cat');

  // Eng so'nggi nashr oyi (issue tag uchun)
  $hdrLatest = \App\Models\JournalArticle::where('status', \App\Models\JournalArticle::ST_PUBLISHED)
    ->whereNotNull('publish_date')
    ->orderByDesc('publish_date')
    ->first();
  $hdrIssueLabel = $hdrLatest && $hdrLatest->publish_date
    ? mb_strtoupper($hdrLatest->publish_date->locale($loc)->isoFormat('YYYY · MMMM'))
    : null;
@endphp
<!-- ══ JOURNAL — HEADER ══ -->
<header class="jsite-hdr" role="banner">

  <!-- Top utility bar -->
  <div class="jsite-hdr-top">
    <div class="jsite-container jsite-hdr-top-row">

      <a href="{{ route('index') }}" class="jsite-brand" aria-label="IMRS Journal">
        <span class="jsite-brand-mini" aria-hidden="true">IMRS</span>
        <img src="{{ asset('assets/img/logo-light.png') }}" alt="IMRS — Institute for Macroeconomic and Regional Studies" class="jsite-logo-img jsite-logo-light">
        <img src="{{ asset('assets/img/logo-dark.png') }}" alt="IMRS — Institute for Macroeconomic and Regional Studies" class="jsite-logo-img jsite-logo-dark">
      </a>

      <form class="jsite-search" role="search" onsubmit="event.preventDefault();">
        <span class="jsite-search-ico" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </span>
        <input type="text" placeholder="@lang('journal.search_placeholder')" aria-label="Search">
      </form>

      <div class="jsite-hdr-actions">

        <a href="{{ $jUser ? route('journal.cabinet') : route('journal.auth.login') }}" class="jsite-cta">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          <span>@lang('journal.submit_article')</span>
        </a>

        <span class="jsite-hdr-sep" aria-hidden="true"></span>

        @guest('journal')
          <a href="{{ route('journal.auth.register') }}" class="jsite-hdr-link">@lang('journal.register')</a>

          <a href="{{ route('journal.auth.login') }}" class="jsite-btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            <span>@lang('journal.login')</span>
          </a>
        @endguest

        @auth('journal')
          @if ($jUser->isSuperAdmin())
            <a href="{{ route('journal.admin.users') }}" class="jsite-hdr-link jsite-hdr-link-admin">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              <span>@lang('journal.admin.panel')</span>
            </a>
          @endif

          @if ($jUser->isTechnic())
            <a href="{{ route('journal.technic.dashboard') }}" class="jsite-hdr-link jsite-hdr-link-panel">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
              <span>@lang('journal.tec.panel')</span>
            </a>
          @endif

          @if ($jUser->isModerator())
            <a href="{{ route('journal.moderator.dashboard') }}" class="jsite-hdr-link jsite-hdr-link-panel">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 19a6 6 0 0 0-12 0"/><circle cx="8" cy="9" r="4"/><path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"/></svg>
              <span>@lang('journal.mod.panel')</span>
            </a>
          @endif

          @if ($jUser->isReviewer())
            <a href="{{ route('journal.reviewer.dashboard') }}" class="jsite-hdr-link jsite-hdr-link-panel">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><polyline points="9 14 11 16 15 12"/></svg>
              <span>@lang('journal.rev.panel')</span>
            </a>
          @endif

          <a href="{{ route('journal.cabinet') }}" class="jsite-hdr-link">{{ $jUser->shortName() }}</a>

          <form method="POST" action="{{ route('journal.auth.logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="jsite-btn-ghost">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              <span>@lang('journal.logout')</span>
            </button>
          </form>
        @endauth

        <span class="jsite-hdr-sep" aria-hidden="true"></span>

        <div class="jsite-lang" role="group" aria-label="Language">
          <a href="{{ route('changelocale', 'uz') }}" class="@if($loc==='uz') is-act @endif">UZ</a>
          <a href="{{ route('changelocale', 'en') }}" class="@if($loc==='en') is-act @endif">ENG</a>
          <a href="{{ route('changelocale', 'ru') }}" class="@if($loc==='ru') is-act @endif">RUS</a>
        </div>

        <button id="jsiteThemeBtn" class="jsite-ico-btn" type="button" aria-label="Theme">
          <svg class="jsite-ico-sun" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
          <svg class="jsite-ico-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>
      </div>

    </div>
  </div>

  <!-- Category nav bar -->
  <nav class="jsite-hdr-nav" aria-label="Categories">
    <div class="jsite-container jsite-hdr-nav-row">
      <ul class="jsite-nav-list">
        <li @class(['is-act' => !$hdrActiveCat])><a href="{{ route('journals') }}" data-cat="all" @if(!$hdrActiveCat) aria-current="page" @endif>@lang('journal.nav.all') @if($hdrTotal)<span class="jsite-nav-cnt">{{ $hdrTotal }}</span>@endif</a></li>
        @foreach($hdrCategories as $cat)
          @php $cnt = (int) ($hdrCategoryCounts[$cat] ?? 0); @endphp
          <li @class(['is-act' => $hdrActiveCat === $cat])>
            <a href="{{ route('journals', ['cat' => $cat]) }}" data-cat="{{ $cat }}" @if($hdrActiveCat === $cat) aria-current="page" @endif>
              {{ $cat }}@if($cnt)<span class="jsite-nav-cnt">{{ $cnt }}</span>@endif
            </a>
          </li>
        @endforeach
      </ul>
      @if($hdrIssueLabel)
        <div class="jsite-issue-tag">
          <span class="jsite-issue-dot" aria-hidden="true"></span>
          {{ $hdrIssueLabel }}
        </div>
      @endif
    </div>
  </nav>

</header>
