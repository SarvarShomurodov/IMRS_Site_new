@extends('client.layouts.app')

@section('metadata')
  <title>@lang('site.science') | @lang('index.index')</title>
  <meta name="description" content="@lang('site.science') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('site.science')">
  <meta property="og:title" content="@lang('site.science') | @lang('index.index')">
  <meta property="og:description" content="@lang('site.science') | @lang('index.index_des')">
@endsection

@section('content')
@php
  $today = \Carbon\Carbon::now();
@endphp

<!-- ── SCIENCE MASTHEAD ── -->
@php
  $sciVideo = \App\Models\PageHero::video('science');
  $sciImg   = \App\Models\PageHero::url('science');
@endphp
<section class="prx-masthead @if($sciVideo || $sciImg) has-media @endif @if($sciVideo) has-video @endif"
         aria-labelledby="sci-h"
         @if($sciImg && !$sciVideo) style="--ph-bg:url('{{ $sciImg }}')" @endif>
  @if($sciVideo)
    <video class="prx-mh-video" autoplay muted loop playsinline @if($sciImg) poster="{{ $sciImg }}" @endif>
      <source src="{{ $sciVideo }}">
    </video>
    <span class="prx-mh-media-overlay" aria-hidden="true"></span>
  @endif
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.science')</span>
    </nav>

    <div class="prx-mh-grid" data-aos="fade-up">
      <div class="prx-mh-l">
        <p class="prx-mh-eyebrow">
          <span class="prx-mh-dot" aria-hidden="true"></span>
          @lang('site.science') · {{ $today->translatedFormat('F Y') }}
        </p>
        <h1 class="prx-mh-title" id="sci-h">@lang('site.sci_title')</h1>
        <p class="prx-mh-sub">@lang('site.sci_sub')</p>
      </div>
      <div class="prx-mh-r">
        <span class="prx-mh-rule" aria-hidden="true"></span>
        <dl class="prx-mh-stats" aria-label="@lang('site.science')">
          <a class="prx-mh-stat" href="#sci-doctoral">
            <span class="prx-stat-idx" aria-hidden="true">01</span>
            <dt class="prx-stat-lbl">@lang('site.science_doctoral')</dt>
            <dd class="prx-stat-num">{{ $doctoralCount }}</dd>
          </a>
          <a class="prx-mh-stat" href="#sci-council">
            <span class="prx-stat-idx" aria-hidden="true">02</span>
            <dt class="prx-stat-lbl">@lang('site.sci_council_short')</dt>
            <dd class="prx-stat-num">{{ $council->count() ?: '·' }}</dd>
          </a>
          <a class="prx-mh-stat" href="#sci-meetings">
            <span class="prx-stat-idx" aria-hidden="true">03</span>
            <dt class="prx-stat-lbl">@lang('site.sci_meetings_short')</dt>
            <dd class="prx-stat-num">{{ $meetings->count() }}</dd>
          </a>
          <a class="prx-mh-stat" href="#sci-protect">
            <span class="prx-stat-idx" aria-hidden="true">04</span>
            <dt class="prx-stat-lbl">@lang('index.protection')</dt>
            <dd class="prx-stat-num">{{ $scholarsCount }}</dd>
          </a>
        </dl>
      </div>
    </div>

    <!-- Quick jump tabs -->
    <div class="prx-tabs" role="tablist" data-aos="fade-up">
      <a href="#sci-doctoral" class="prx-tab is-active" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        @lang('site.science_doctoral')
      </a>
      <a href="#sci-council" class="prx-tab" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
        @lang('site.science_council_info')
      </a>
      <a href="#sci-meetings" class="prx-tab" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        @lang('site.science_council_meetings')
      </a>
      <a href="#sci-protect" class="prx-tab" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
        @lang('index.protection')
      </a>
    </div>
  </div>
</section>

@if($doctoral->count() > 0 && $doctoralCat)
<!-- ── 01 DOCTORAL STUDENTS ── -->
<section id="sci-doctoral" class="prx-mat-sec" aria-labelledby="sci-doc-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">01</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.sci_eyebrow_doctoral')</p>
        <h2 class="prx-sec-title" id="sci-doc-h">@lang('site.science_doctoral')</h2>
      </div>
      <a class="prx-sec-all" href="{{ route('pages', $doctoralCat->slug) }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    <div class="prx-mat-grid">
      @foreach($doctoral as $item)
        @php
          $shortDesc = '';
          if (!empty($item->{'description_'.app()->getLocale()})) {
            $sd = html_entity_decode(strip_tags($item->{'description_'.app()->getLocale()}), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $shortDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', $sd)), 130);
          }
        @endphp
        <a class="prx-mat-card" href="{{ route('page', $item->slug) }}">
          <span class="prx-mat-cover">
            @if($item->issetImage())
              <img src="{{ $item->getImageAttribute() }}" alt="{{ $item->getTitleAttribute() }}" loading="lazy">
            @else
              <span class="prx-img-ph" aria-hidden="true">
                <span class="prx-img-ph-letter">{{ mb_substr($item->getTitleAttribute(), 0, 1) }}</span>
              </span>
            @endif
            <span class="prx-mat-cover-tag">@lang('site.science_doctoral')</span>
          </span>
          <span class="prx-mat-body">
            <h3 class="prx-mat-title">{{ $item->getTitleAttribute() }}</h3>
            @if($shortDesc)
              <p class="prx-mat-desc">{{ $shortDesc }}</p>
            @endif
            <span class="prx-mat-foot">
              <span class="prx-mat-date">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
              </span>
              <span class="prx-mat-arrow" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </span>
          </span>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

@if($councilCat)
<!-- ── 02 SCIENTIFIC COUNCIL INFO ── -->
<section id="sci-council" class="sci-council-sec" aria-labelledby="sci-cnc-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">02</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.sci_eyebrow_council')</p>
        <h2 class="prx-sec-title" id="sci-cnc-h">@lang('site.science_council_info')</h2>
      </div>
      <a class="prx-sec-all" href="{{ route('pages', $councilCat->slug) }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    @if($council->count() > 0)
      <div class="prx-mat-grid">
        @foreach($council as $item)
          @php
            $shortDesc = '';
            if (!empty($item->{'description_'.app()->getLocale()})) {
              $sd = html_entity_decode(strip_tags($item->{'description_'.app()->getLocale()}), ENT_QUOTES | ENT_HTML5, 'UTF-8');
              $shortDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', $sd)), 130);
            }
          @endphp
          <a class="prx-mat-card" href="{{ route('page', $item->slug) }}">
            <span class="prx-mat-cover">
              @if($item->issetImage())
                <img src="{{ $item->getImageAttribute() }}" alt="{{ $item->getTitleAttribute() }}" loading="lazy">
              @else
                <span class="prx-img-ph" aria-hidden="true">
                  <span class="prx-img-ph-letter">{{ mb_substr($item->getTitleAttribute(), 0, 1) }}</span>
                </span>
              @endif
              <span class="prx-mat-cover-tag">@lang('site.sci_council_short')</span>
            </span>
            <span class="prx-mat-body">
              <h3 class="prx-mat-title">{{ $item->getTitleAttribute() }}</h3>
              @if($shortDesc)
                <p class="prx-mat-desc">{{ $shortDesc }}</p>
              @endif
              <span class="prx-mat-foot">
                <span class="prx-mat-date">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>
                <span class="prx-mat-arrow" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
              </span>
            </span>
          </a>
        @endforeach
      </div>
    @else
      <a class="sci-council-card" href="{{ route('pages', $councilCat->slug) }}" data-aos="fade-up">
        <span class="sci-council-emblem" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
        </span>
        <div class="sci-council-body">
          <p class="sci-council-tag">@lang('site.sci_eyebrow_council')</p>
          <h3 class="sci-council-title">{{ $councilCat->getTitleAttribute() }}</h3>
          <p class="sci-council-desc">@lang('site.sci_council_desc')</p>
          <span class="sci-council-cta">
            @lang('site.read_more')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </span>
        </div>
      </a>
    @endif
  </div>
</section>
@endif

@if($meetings->count() > 0 && $meetingsCat)
<!-- ── 03 COUNCIL MEETINGS (timeline) ── -->
<section id="sci-meetings" class="prx-conf-sec" aria-labelledby="sci-mtg-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">03</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.sci_eyebrow_meetings')</p>
        <h2 class="prx-sec-title" id="sci-mtg-h">@lang('site.science_council_meetings')</h2>
      </div>
      <a class="prx-sec-all" href="{{ route('pages', $meetingsCat->slug) }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    <ul class="prx-timeline">
      @foreach($meetings as $mtg)
        @php
          $cd = \Carbon\Carbon::parse($mtg->created_at);
          $mtgDesc = '';
          if (!empty($mtg->{'description_'.app()->getLocale()})) {
            $rd = html_entity_decode(strip_tags($mtg->{'description_'.app()->getLocale()}), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $mtgDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', $rd)), 160);
          }
        @endphp
        <li class="prx-tl-item" data-aos="fade-up">
          <div class="prx-tl-date">
            <span class="prx-tl-day">{{ $cd->format('d') }}</span>
            <span class="prx-tl-mon">{{ $cd->translatedFormat('M') }}</span>
            <span class="prx-tl-year">{{ $cd->format('Y') }}</span>
          </div>
          <div class="prx-tl-stem" aria-hidden="true">
            <span class="prx-tl-bullet"></span>
            <span class="prx-tl-line"></span>
          </div>
          <a class="prx-tl-card has-img" href="{{ route('page', $mtg->slug) }}">
            <span class="prx-tl-thumb">
              @if($mtg->issetImage())
                <img src="{{ $mtg->getImageAttribute() }}" alt="{{ $mtg->getTitleAttribute() }}" loading="lazy">
              @else
                <span class="prx-img-ph" aria-hidden="true">
                  <span class="prx-img-ph-letter">{{ mb_substr($mtg->getTitleAttribute(), 0, 1) }}</span>
                </span>
              @endif
            </span>
            <span class="prx-tl-body">
              <p class="prx-tl-tag">@lang('site.science_council_meetings')</p>
              <h3 class="prx-tl-title">{{ $mtg->getTitleAttribute() }}</h3>
              @if($mtgDesc)
                <p class="prx-tl-desc">{{ $mtgDesc }}</p>
              @endif
              <span class="prx-tl-cta">
                @lang('site.read_more')
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </span>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</section>
@endif

@if($scholars->count() > 0)
<!-- ── 04 DISSERTATION PROTECTION (scholars) ── -->
<section id="sci-protect" class="sci-protect-sec" aria-labelledby="sci-pro-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">04</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.sci_eyebrow_protect')</p>
        <h2 class="prx-sec-title" id="sci-pro-h">@lang('index.protection')</h2>
      </div>
      <a class="prx-sec-all" href="{{ route('protection') }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    <div class="sci-pro-grid">
      @foreach($scholars as $sc)
        <article class="sci-pro-card" data-aos="fade-up">
          <div class="sci-pro-photo">
            @if(!empty($sc->image))
              <img src="/images/scholars/{{ $sc->image }}" alt="{{ $sc->getNameAttribute() }}" loading="lazy">
            @else
              <span class="prx-img-ph" aria-hidden="true">
                <span class="prx-img-ph-letter">{{ mb_substr($sc->getNameAttribute(), 0, 1) }}</span>
              </span>
            @endif
            @if($sc->getPhdDscAttribute())
              <span class="sci-pro-degree">{{ $sc->getPhdDscAttribute() }}</span>
            @endif
          </div>
          <div class="sci-pro-body">
            <h3 class="sci-pro-name">{{ $sc->getNameAttribute() }}</h3>
            @if($sc->getThemeAttribute())
              <p class="sci-pro-theme">"{{ $sc->getThemeAttribute() }}"</p>
            @endif
            <div class="sci-pro-meta">
              @if($sc->getPlaceAttribute())
                <span class="sci-pro-place">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                  {{ $sc->getPlaceAttribute() }}
                </span>
              @endif
              <span class="sci-pro-date">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $sc->getCreatedData() }}
              </span>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function(){
  var tabs = document.querySelectorAll('.prx-tab');
  var sections = ['sci-doctoral','sci-council','sci-meetings','sci-protect']
                  .map(function(id){ return document.getElementById(id); })
                  .filter(Boolean);

  function setActive(){
    var y = window.scrollY + 120;
    var current = sections[0];
    sections.forEach(function(s){ if (s && s.offsetTop <= y) current = s; });
    if (!current) return;
    tabs.forEach(function(t){
      t.classList.toggle('is-active', t.getAttribute('href') === '#' + current.id);
    });
  }
  if (sections.length){
    setActive();
    window.addEventListener('scroll', setActive, {passive:true});
  }
})();
</script>
@endpush
