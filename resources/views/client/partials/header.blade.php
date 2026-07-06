<!-- ══ HEADER ══ -->
@php
  $loc  = app()->getLocale();
  $path = trim(request()->path(), '/');
  $activeNav = '';

  // /pages/{slug} → toifaga qarab parent nav aniqlanadi
  $pagesPressSlugs    = ['informaciya-o-predstoyashhix-konferenciyax-1', 'sbornik-materialov'];
  $pagesScienceSlugs  = ['for-doctoral-students', 'naucnyi-sovet', 'scientific-council-meeting'];
  $pagesVacanciesSlug = 'vacancies';
  $pagesWebinarSlug   = 'webinar';
  $pagesAboutSlugs    = ['informaciya'];

  if ($path === '' || $path === '/') {
    $activeNav = 'home';
  } elseif (str_starts_with($path, 'pages/')) {
    $pSlug = ltrim(substr($path, strlen('pages/')), '/');
    if (in_array($pSlug, $pagesPressSlugs))        $activeNav = 'press';
    elseif (in_array($pSlug, $pagesScienceSlugs))  $activeNav = 'science';
    elseif ($pSlug === $pagesVacanciesSlug)        $activeNav = 'vacancies';
    elseif ($pSlug === $pagesWebinarSlug)          $activeNav = 'webinars';
    elseif (in_array($pSlug, $pagesAboutSlugs))    $activeNav = 'about';
    else                                            $activeNav = 'about'; // default fallback
  } elseif (str_starts_with($path, 'page/')) {
    // Yagona sahifa — kategoriyasiga qarab parent nav aniqlanadi
    $pageSlug = ltrim(substr($path, strlen('page/')), '/');
    $pageObj  = \App\Models\Page::where('slug', $pageSlug)->first();
    $pageCat  = $pageObj ? optional($pageObj->categories->first())->slug : null;
    if ($pageCat && in_array($pageCat, $pagesPressSlugs))        $activeNav = 'press';
    elseif ($pageCat && in_array($pageCat, $pagesScienceSlugs))  $activeNav = 'science';
    elseif ($pageCat === $pagesVacanciesSlug)                    $activeNav = 'vacancies';
    elseif ($pageCat === $pagesWebinarSlug)                      $activeNav = 'webinars';
    else                                                          $activeNav = 'about';
  } elseif (str_starts_with($path, 'administrations') || str_starts_with($path, 'structure') ||
            str_starts_with($path, 'employees') || str_starts_with($path, 'p/history')) {
    $activeNav = 'about';
  } elseif (str_starts_with($path, 'laws/') || str_starts_with($path, 'korrupsiyaga')) {
    $activeNav = 'legal';
  } elseif (str_starts_with($path, 'press') || str_starts_with($path, 'archives') ||
            str_starts_with($path, 'photos') || str_starts_with($path, 'videos') ||
            str_starts_with($path, 'konferensiyalar') || str_starts_with($path, 'materiallar')) {
    $activeNav = 'press';
  } elseif (str_starts_with($path, 'science') || str_starts_with($path, 'declaration-of-protection')) {
    $activeNav = 'science';
  } elseif (str_starts_with($path, 'publications') || str_starts_with($path, 'publication')) {
    $activeNav = 'pubs';
  } elseif (str_starts_with($path, 'journals') || str_starts_with($path, 'journal-archive') ||
            str_starts_with($path, 'journal')) {
    $activeNav = 'journal';
  }
@endphp
<header id="hdr" role="banner">
  <div class="container">
    <nav class="nav-wrap" aria-label="@lang('site.main_nav')">

      <a href="/" class="logo" aria-label="@lang('site.imrs_home')">
        <img src="{{ asset('assets/img/logo-light.png') }}" alt="IMRS — Institute for Macroeconomic and Regional Studies" class="logo-img logo-img-light">
        <img src="{{ asset('assets/img/logo-dark.png') }}" alt="IMRS — Institute for Macroeconomic and Regional Studies" class="logo-img logo-img-dark">
      </a>

      <ul class="nav-links" role="list">
        <li class="nav-item has-sub">
          <a href="/" @if($activeNav==='about') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="22" x2="21" y2="22"/><line x1="3" y1="11" x2="21" y2="11"/><polyline points="5 7 12 3 19 7"/><line x1="4" y1="22" x2="4" y2="11"/><line x1="20" y1="22" x2="20" y2="11"/><line x1="8" y1="14" x2="8" y2="19"/><line x1="12" y1="14" x2="12" y2="19"/><line x1="16" y1="14" x2="16" y2="19"/></svg> @lang('site.about') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></a>
          <div class="dropdown" role="menu">
            <a href="{{ route('history') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><path d="M12 7v5l4 2"/></svg> @lang('site.history')</a>
            <a href="{{ url('/administrations') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 19a6 6 0 0 0-12 0"/><circle cx="8" cy="9" r="4"/><path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"/></svg> @lang('site.leadership')</a>
            <a href="{{ url('/structure') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="6" rx="1"/><rect x="16" y="9" width="6" height="6" rx="1"/><rect x="2" y="9" width="6" height="6" rx="1"/><path d="M5.25 15.25v3.25a2 2 0 0 0 2 2h9.5a2 2 0 0 0 2-2v-3.25"/><path d="M12 8v1.5m0 5V15m-6.75-.75h3.5M15.25 14.25h3.5"/></svg> @lang('site.structure')</a>
            <a href="{{ route('employees') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> @lang('site.employees')</a>
          </div>
        </li>
        <li class="nav-item has-sub">
          <a href="{{ route('publications.all') }}" @if($activeNav==='pubs') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> @lang('site.publications') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></a>
          <div class="dropdown" role="menu">
            <a href="{{ route('publications', 'articles-and-abstracts') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> @lang('site.articles_thesis')</a>
            <div class="dropdown-title"><a href="{{ route('publications', 'reviews-by-industry-sector') }}">@lang('site.sectoral_review')</a></div>
            <a href="{{ route('publications', 'macroeconomics') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg> @lang('site.macroeconomy')</a>
            <a href="{{ route('publications', 'world-food-markets') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 22 16 8"/><path d="M3.47 12.53 5 11l1.53 1.53a3.5 3.5 0 0 1 0 4.94L5 19l-1.53-1.53a3.5 3.5 0 0 1 0-4.94z"/><path d="M7.47 8.53 9 7l1.53 1.53a3.5 3.5 0 0 1 0 4.94L9 15l-1.53-1.53a3.5 3.5 0 0 1 0-4.94z"/><path d="M11.47 4.53 13 3l1.53 1.53a3.5 3.5 0 0 1 0 4.94L13 11l-1.53-1.53a3.5 3.5 0 0 1 0-4.94z"/><path d="M20 2h2v2a4 4 0 0 1-4 4h-2V6a4 4 0 0 1 4-4z"/><path d="M11.47 17.47 13 19l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L5 19l1.53-1.53a3.5 3.5 0 0 1 4.94 0z"/></svg> @lang('site.world_food_markets')</a>
            <a href="{{ route('publications', 'industry') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/><path d="M17 18h1"/><path d="M12 18h1"/><path d="M7 18h1"/></svg> @lang('site.industry')</a>
            <a href="{{ route('publications', 'regional-economy') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg> @lang('site.regional_economy')</a>
            <a href="{{ route('publications', 'transport-and-logistic') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg> @lang('site.transport_logistics')</a>
            <a href="{{ route('publications', 'foreign-economic-activity') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg> @lang('site.foreign_trade')</a>
            <a href="{{ route('publications', 'investments') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="22" x2="21" y2="22"/><line x1="6" y1="18" x2="6" y2="11"/><line x1="10" y1="18" x2="10" y2="11"/><line x1="14" y1="18" x2="14" y2="11"/><line x1="18" y1="18" x2="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg> @lang('site.investments')</a>
            <a href="{{ route('publications', 'social-sphere') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="m12 13-1-1 2-2-3-3 2-2"/><path d="m15 14-2-2 2-2"/></svg> @lang('site.social_sphere')</a>
          </div>
        </li>
        <li class="nav-item has-sub">
          <a href="{{ route('science') }}" @if($activeNav==='science') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1.2"/><ellipse cx="12" cy="12" rx="10" ry="4"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(60 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(120 12 12)"/></svg> @lang('site.science') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></a>
          <div class="dropdown" role="menu">
            {{-- <a href="{{ route('science') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> @lang('site.prx_overview')</a> --}}
            <a href="{{ route('pages', 'for-doctoral-students') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg> @lang('site.science_doctoral')</a>
            <a href="{{ route('pages', 'naucnyi-sovet') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg> @lang('site.science_council_info')</a>
            <a href="{{ route('pages', 'scientific-council-meeting') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> @lang('site.science_council_meetings')</a>
            <a href="{{ route('protection') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg> @lang('index.protection')</a>
          </div>
        </li>
        {{-- <li class="nav-item has-sub">
          <a href="{{ route('journals') }}" @if($activeNav==='journal') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="9" y1="7" x2="16" y2="7"/><line x1="9" y1="11" x2="13" y2="11"/></svg> @lang('site.journal') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></a>
          <div class="dropdown" role="menu">
            <a href="{{ route('journals.archive') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> @lang('site.journals_archive')</a>
            <a href="{{ route('journals') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> @lang('site.submit_article')</a>
          </div>
        </li> --}}
        <li class="nav-item"><a href="{{ route('journals') }}" target="_blank" rel="noopener" @if($activeNav==='journal') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><line x1="2" y1="13" x2="22" y2="13"/></svg> @lang('site.journal')</a></li>
        {{-- <li class="nav-item has-sub">
          <a href="{{ route('laws', 'laws-and-codes') }}" @if($activeNav==='legal') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21h12a2 2 0 0 0 2-2v-2H10v2a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v3h4"/><path d="M19 17V5a2 2 0 0 0-2-2H4"/><path d="M15 8h-5"/><path d="M15 12h-5"/></svg> @lang('site.legal_base') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></a>
          <div class="dropdown" role="menu">
            <a href="{{ route('laws', 'laws-and-codes') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21h12a2 2 0 0 0 2-2v-2H10v2a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v3h4"/><path d="M19 17V5a2 2 0 0 0-2-2H4"/><path d="M15 8h-5"/><path d="M15 12h-5"/></svg> @lang('site.laws_codes')</a>
            <a href="{{ route('laws', 'decrees') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M19.27 13.73A2.5 2.5 0 0 0 17.5 13h-11A2.5 2.5 0 0 0 4 15.5V17a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-1.5c0-.66-.26-1.3-.73-1.77z"/><path d="M14 13V8.5C14 7 15 7 15 5a3 3 0 0 0-6 0c0 2 1 2 1 3.5V13"/></svg> @lang('site.decrees')</a>
            <a href="{{ route('laws', 'resolutions') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><polyline points="9 15 11 17 15 13"/></svg> @lang('site.resolutions')</a>
            <div class="dropdown-title">@lang('site.anticorruption')</div>
            <a href="{{ route('laws', 'test-protivodeistvie-korrupcii') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg> @lang('site.anticorruption_docs')</a>
          </div>
        </li> --}}
        <li class="nav-item has-sub">
          <a href="{{ route('press') }}" @if($activeNav==='press') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a4 4 0 0 1-4-4V6"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6z"/></svg> @lang('site.press') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></a>
          <div class="dropdown" role="menu">
            {{-- <a href="{{ route('press') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> @lang('site.prx_overview')</a> --}}
            <a href="{{ route('archives', 'news') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/></svg> @lang('site.news')</a>
            <a href="{{ route('pages', 'informaciya-o-predstoyashhix-konferenciyax-1') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg> @lang('site.conferences')</a>
            <a href="{{ route('pages', 'sbornik-materialov') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 16V4a2 2 0 0 1 2-2h11"/><path d="M22 18H11a2 2 0 1 0 0 4h10.5a.5.5 0 0 0 .5-.5v-15a.5.5 0 0 0-.5-.5H11a2 2 0 0 0-2 2v12"/><path d="M5 14H4a2 2 0 1 0 0 4h1"/></svg> @lang('site.materials')</a>
            <a href="{{ route('photos') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg> @lang('site.photogallery')</a>
            <a href="{{ route('videos') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg> @lang('site.videogallery')</a>
          </div>
        </li>
        <li class="nav-item"><a href="{{ route('pages', 'webinar') }}" @if($activeNav==='webinars') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/><polygon points="10 8 15 10.5 10 13" fill="currentColor" stroke="none"/></svg> @lang('site.webinars')</a></li>
        <li class="nav-item has-sub">
          <a href="{{ route('laws', 'laws-and-codes') }}" @if($activeNav==='legal') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21h12a2 2 0 0 0 2-2v-2H10v2a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v3h4"/><path d="M19 17V5a2 2 0 0 0-2-2H4"/><path d="M15 8h-5"/><path d="M15 12h-5"/></svg> @lang('site.legal_base') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></a>
          <div class="dropdown" role="menu">
            <a href="{{ route('laws', 'laws-and-codes') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21h12a2 2 0 0 0 2-2v-2H10v2a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v3h4"/><path d="M19 17V5a2 2 0 0 0-2-2H4"/><path d="M15 8h-5"/><path d="M15 12h-5"/></svg> @lang('site.laws_codes')</a>
            <a href="{{ route('laws', 'decrees') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M19.27 13.73A2.5 2.5 0 0 0 17.5 13h-11A2.5 2.5 0 0 0 4 15.5V17a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-1.5c0-.66-.26-1.3-.73-1.77z"/><path d="M14 13V8.5C14 7 15 7 15 5a3 3 0 0 0-6 0c0 2 1 2 1 3.5V13"/></svg> @lang('site.decrees')</a>
            <a href="{{ route('laws', 'resolutions') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><polyline points="9 15 11 17 15 13"/></svg> @lang('site.resolutions')</a>
            <div class="dropdown-title">@lang('site.anticorruption')</div>
            <a href="{{ route('laws', 'test-protivodeistvie-korrupcii') }}" role="menuitem"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg> @lang('site.anticorruption_docs')</a>
          </div>
        </li>
        <li class="nav-item"><a href="{{ route('pages', 'vacancies') }}" @if($activeNav==='vacancies') aria-current="page" @endif><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><line x1="2" y1="13" x2="22" y2="13"/></svg> @lang('site.vacancies')</a></li>
      </ul>

      <div class="nav-right">
        <div class="lang-dd" id="langDd">
          <button class="lang-dd-toggle" id="langDdBtn" type="button" aria-haspopup="true" aria-expanded="false" aria-label="@lang('site.lang_select')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" class="lang-dd-globe"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            <span class="lang-dd-cur">{{ strtoupper($loc) }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lang-dd-chev"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="lang-dd-menu" role="menu" aria-label="@lang('site.lang_select')">
            <a href="{{ route('changelocale', 'uz') }}" class="lang-dd-item @if($loc==='uz') is-act @endif" role="menuitem"><span class="lang-dd-name">O‘zbekcha</span><span class="lang-dd-code">UZ</span></a>
            <a href="{{ route('changelocale', 'ru') }}" class="lang-dd-item @if($loc==='ru') is-act @endif" role="menuitem"><span class="lang-dd-name">Русский</span><span class="lang-dd-code">RU</span></a>
            <a href="{{ route('changelocale', 'en') }}" class="lang-dd-item @if($loc==='en') is-act @endif" role="menuitem"><span class="lang-dd-name">English</span><span class="lang-dd-code">EN</span></a>
          </div>
        </div>
        <button class="ico-btn" id="searchBtn" type="button" aria-label="@lang('site.search')" aria-controls="searchOverlay" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></button>
        <button class="ico-btn" id="tBtn" aria-label="@lang('site.theme')"><i data-lucide="sun" id="tIco"></i></button>
        <button class="burger" id="burg" aria-label="@lang('site.menu')" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
      </div>

    </nav>
  </div>

  <div id="searchOverlay" class="search-overlay" role="dialog" aria-modal="true" aria-label="@lang('site.search')" hidden>
    <div class="search-overlay__backdrop" data-search-close></div>
    <div class="search-overlay__panel" role="search">
      <form action="{{ route('search') }}" method="get" class="search-overlay__form">
        <svg class="search-overlay__icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="search" name="query" id="searchInput" class="search-overlay__input" placeholder="@lang('index.search_for')..." autocomplete="off" required>
        <button type="submit" class="search-overlay__submit">@lang('site.search')</button>
        <button type="button" class="search-overlay__close" aria-label="@lang('site.search')" data-search-close>
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </form>
    </div>
  </div>
</header>

<script>
(function () {
  var btn     = document.getElementById('searchBtn');
  var overlay = document.getElementById('searchOverlay');
  var input   = document.getElementById('searchInput');
  if (!btn || !overlay || !input) return;

  function open() {
    overlay.hidden = false;
    requestAnimationFrame(function () { overlay.classList.add('is-open'); });
    btn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    setTimeout(function () { input.focus(); }, 60);
  }
  function close() {
    overlay.classList.remove('is-open');
    btn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    setTimeout(function () { overlay.hidden = true; }, 220);
  }

  btn.addEventListener('click', function (e) { e.preventDefault(); open(); });
  overlay.querySelectorAll('[data-search-close]').forEach(function (el) {
    el.addEventListener('click', close);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !overlay.hidden) close();
  });
})();

/* ── Til dropdown ── */
(function () {
  var dd  = document.getElementById('langDd');
  var btn = document.getElementById('langDdBtn');
  if (!dd || !btn) return;

  function openDd()  { dd.classList.add('is-open');  btn.setAttribute('aria-expanded', 'true'); }
  function closeDd() { dd.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }

  btn.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    dd.classList.contains('is-open') ? closeDd() : openDd();
  });
  document.addEventListener('click', function (e) {
    if (!dd.contains(e.target)) closeDd();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDd();
  });
})();
</script>
