@extends('client.layouts.app')

@section('metadata')
  <title>@lang('site.press') | @lang('index.index')</title>
  <meta name="description" content="@lang('site.press') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('site.press')">
  <meta property="og:title" content="@lang('site.press') | @lang('index.index')">
  <meta property="og:description" content="@lang('site.press') | @lang('index.index_des')">
@endsection

@section('content')
@php
  // Featured (first news with image preferred)
  $newsColl = collect($news);
  $featured = $newsColl->first(function ($n) { return $n->issetImage(); }) ?: $newsColl->first();
  $newsRest = $newsColl->reject(function ($n) use ($featured) { return $featured && $n->id === $featured->id; })->take(6)->values();

  $featDesc = '';
  if ($featured && $featured->issetDescription()) {
    $featDesc = html_entity_decode(strip_tags($featured->getShortDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $featDesc = trim(preg_replace('/\s+/u', ' ', $featDesc));
    $featDesc = \Illuminate\Support\Str::limit($featDesc, 220);
  }

  // YouTube ID extractor for videos
  $extractYt = function($url) {
    if (empty($url)) return null;
    $patterns = [
      '#youtube\.com/embed/([A-Za-z0-9_-]{6,15})#i',
      '#youtube\.com/watch\?v=([A-Za-z0-9_-]{6,15})#i',
      '#youtu\.be/([A-Za-z0-9_-]{6,15})#i',
      '#youtube\.com/v/([A-Za-z0-9_-]{6,15})#i',
      '#youtube\.com/shorts/([A-Za-z0-9_-]{6,15})#i',
    ];
    foreach ($patterns as $p) {
      if (preg_match($p, $url, $m)) return $m[1];
    }
    return null;
  };

  $today = \Carbon\Carbon::now();
@endphp

<!-- ── PRESS MASTHEAD ── -->
@php
  $pressVideo = \App\Models\PageHero::video('press');
  $pressImg   = \App\Models\PageHero::url('press');
@endphp
<section class="prx-masthead @if($pressVideo || $pressImg) has-media @endif @if($pressVideo) has-video @endif"
         aria-labelledby="prx-h"
         @if($pressImg && !$pressVideo) style="--ph-bg:url('{{ $pressImg }}')" @endif>
  @if($pressVideo)
    <video class="prx-mh-video" autoplay muted loop playsinline @if($pressImg) poster="{{ $pressImg }}" @endif>
      <source src="{{ $pressVideo }}">
    </video>
    <span class="prx-mh-media-overlay" aria-hidden="true"></span>
  @endif
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.press')</span>
    </nav>

    <div class="prx-mh-grid" data-aos="fade-up">
      <div class="prx-mh-l">
        <p class="prx-mh-eyebrow">
          <span class="prx-mh-dot" aria-hidden="true"></span>
          @lang('site.press') · {{ $today->translatedFormat('F Y') }}
        </p>
        <h1 class="prx-mh-title" id="prx-h">@lang('site.prx_title')</h1>
        <p class="prx-mh-sub">@lang('site.prx_sub')</p>
      </div>
      <div class="prx-mh-r">
        <span class="prx-mh-rule" aria-hidden="true"></span>
        <dl class="prx-mh-stats" aria-label="@lang('site.press')">
          <a class="prx-mh-stat" href="#prx-news">
            <span class="prx-stat-idx" aria-hidden="true">01</span>
            <dt class="prx-stat-lbl">@lang('site.news')</dt>
            <dd class="prx-stat-num">{{ \App\Models\News::count() }}</dd>
          </a>
          <a class="prx-mh-stat" href="#prx-conf">
            <span class="prx-stat-idx" aria-hidden="true">02</span>
            <dt class="prx-stat-lbl">@lang('site.conferences')</dt>
            <dd class="prx-stat-num">{{ $conferences->count() }}</dd>
          </a>
          <a class="prx-mh-stat" href="#prx-mat">
            <span class="prx-stat-idx" aria-hidden="true">03</span>
            <dt class="prx-stat-lbl">@lang('site.materials')</dt>
            <dd class="prx-stat-num">{{ $materials->count() }}</dd>
          </a>
          <a class="prx-mh-stat" href="#prx-photo">
            <span class="prx-stat-idx" aria-hidden="true">04</span>
            <dt class="prx-stat-lbl">@lang('site.photogallery')</dt>
            <dd class="prx-stat-num">{{ \App\Models\PhotoGallery::where('status','gallery')->count() }}</dd>
          </a>
          <a class="prx-mh-stat" href="#prx-video">
            <span class="prx-stat-idx" aria-hidden="true">05</span>
            <dt class="prx-stat-lbl">@lang('site.videogallery')</dt>
            <dd class="prx-stat-num">{{ \App\Models\VideoGallery::count() }}</dd>
          </a>
        </dl>
      </div>
    </div>

    <!-- Quick jump tabs (anchor scroll) -->
    <div class="prx-tabs" role="tablist" data-aos="fade-up">
      <a href="#prx-news" class="prx-tab is-active" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/></svg>
        @lang('site.news')
      </a>
      <a href="#prx-conf" class="prx-tab" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        @lang('site.conferences')
      </a>
      <a href="#prx-mat" class="prx-tab" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 16V4a2 2 0 0 1 2-2h11"/><path d="M22 18H11a2 2 0 1 0 0 4h10.5a.5.5 0 0 0 .5-.5v-15a.5.5 0 0 0-.5-.5H11a2 2 0 0 0-2 2v12"/><path d="M5 14H4a2 2 0 1 0 0 4h1"/></svg>
        @lang('site.materials')
      </a>
      <a href="#prx-photo" class="prx-tab" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        @lang('site.photogallery')
      </a>
      <a href="#prx-video" class="prx-tab" role="tab">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        @lang('site.videogallery')
      </a>
    </div>
  </div>
</section>

@if($featured && $newsArchive)
<!-- ── COVER STORY (news) ── -->
<section id="prx-news" class="prx-cover-sec" aria-label="Cover story">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">01</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.news')</p>
        <h2 class="prx-sec-title">@lang('site.prx_news_title')</h2>
      </div>
      <a class="prx-sec-all" href="{{ route('archives', 'news') }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    <div class="prx-cover-grid">
      <a class="prx-cover-main" href="{{ route('news', [$newsArchive->slug, $featured->slug]) }}" data-aos="fade-up">
        <div class="prx-cover-img">
          @if($featured->issetImage())
            <img src="{{ $featured->getImageAttribute() }}" alt="{{ $featured->getTitleAttribute() }}" loading="lazy">
          @else
            <div class="prx-cover-img-ph" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/></svg>
            </div>
          @endif
          <span class="prx-cover-badge">
            <span class="prx-cover-badge-dot" aria-hidden="true"></span>
            @lang('site.arc_featured_tag')
          </span>
        </div>
        <div class="prx-cover-body">
          <p class="prx-cover-cat">@lang('site.news')</p>
          <h3 class="prx-cover-title">{{ $featured->getTitleAttribute() }}</h3>
          @if($featDesc)
            <p class="prx-cover-desc">{{ $featDesc }}</p>
          @endif
          <div class="prx-cover-foot">
            <span class="prx-cover-date">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              {{ $featured->getCreatedData() }}
            </span>
            @if(!empty($featured->views))
              <span class="prx-cover-views">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                {{ $featured->views }} @lang('site.views')
              </span>
            @endif
            <span class="prx-cover-cta">
              @lang('site.read_more')
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
        </div>
      </a>

      @if($newsRest->count() > 0)
      <ol class="prx-news-list" data-aos="fade-left">
        @foreach($newsRest as $i => $n)
          <li>
            <a class="prx-news-item" href="{{ route('news', [$newsArchive->slug, $n->slug]) }}">
              <span class="prx-news-num">{{ str_pad($i + 2, 2, '0', STR_PAD_LEFT) }}</span>
              <div class="prx-news-text">
                <h4 class="prx-news-h">{{ $n->getTitleAttribute() }}</h4>
                <span class="prx-news-date">{{ $n->getCreatedData() }}</span>
              </div>
              @if($n->issetImage())
                <span class="prx-news-thumb"><img src="{{ $n->getImageAttribute() }}" alt="" loading="lazy"></span>
              @endif
            </a>
          </li>
        @endforeach
      </ol>
      @endif
    </div>
  </div>
</section>
@endif

@if($conferences->count() > 0)
<!-- ── UPCOMING CONFERENCES ── -->
<section id="prx-conf" class="prx-conf-sec" aria-labelledby="prx-conf-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">02</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.prx_upcoming')</p>
        <h2 class="prx-sec-title" id="prx-conf-h">@lang('site.conferences')</h2>
      </div>
      @if($conferencesCat)
      <a class="prx-sec-all" href="{{ route('pages', $conferencesCat->slug) }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
      @endif
    </header>

    <ul class="prx-timeline">
      @foreach($conferences as $idx => $conf)
        @php
          $cd = \Carbon\Carbon::parse($conf->created_at);
          $confDesc = '';
          if (!empty($conf->{'description_'.app()->getLocale()})) {
            $rd = html_entity_decode(strip_tags($conf->{'description_'.app()->getLocale()}), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $confDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', $rd)), 160);
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
          <a class="prx-tl-card has-img" href="{{ route('page', $conf->slug) }}">
            <span class="prx-tl-thumb">
              @if($conf->issetImage())
                <img src="{{ $conf->getImageAttribute() }}" alt="{{ $conf->getTitleAttribute() }}" loading="lazy">
              @else
                <span class="prx-img-ph" aria-hidden="true">
                  <span class="prx-img-ph-letter">{{ mb_substr($conf->getTitleAttribute(), 0, 1) }}</span>
                </span>
              @endif
            </span>
            <span class="prx-tl-body">
              <p class="prx-tl-tag">@lang('site.conferences')</p>
              <h3 class="prx-tl-title">{{ $conf->getTitleAttribute() }}</h3>
              @if($confDesc)
                <p class="prx-tl-desc">{{ $confDesc }}</p>
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

@if($materials->count() > 0)
<!-- ── MATERIALS COLLECTION ── -->
<section id="prx-mat" class="prx-mat-sec" aria-labelledby="prx-mat-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">03</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.prx_archive')</p>
        <h2 class="prx-sec-title" id="prx-mat-h">@lang('site.materials')</h2>
      </div>
      @if($materialsCat)
      <a class="prx-sec-all" href="{{ route('pages', $materialsCat->slug) }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
      @endif
    </header>

    <div class="prx-mat-grid">
      @foreach($materials as $mat)
        @php
          $matDesc = '';
          if (!empty($mat->{'description_'.app()->getLocale()})) {
            $md = html_entity_decode(strip_tags($mat->{'description_'.app()->getLocale()}), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $matDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', $md)), 140);
          }
        @endphp
        <a class="prx-mat-card" href="{{ route('page', $mat->slug) }}">
          <span class="prx-mat-cover">
            @if($mat->issetImage())
              <img src="{{ $mat->getImageAttribute() }}" alt="{{ $mat->getTitleAttribute() }}" loading="lazy">
            @else
              <span class="prx-img-ph" aria-hidden="true">
                <span class="prx-img-ph-letter">{{ mb_substr($mat->getTitleAttribute(), 0, 1) }}</span>
              </span>
            @endif
            <span class="prx-mat-cover-tag">@lang('site.materials')</span>
          </span>
          <span class="prx-mat-body">
            <h3 class="prx-mat-title">{{ $mat->getTitleAttribute() }}</h3>
            @if($matDesc)
              <p class="prx-mat-desc">{{ $matDesc }}</p>
            @endif
            <span class="prx-mat-foot">
              <span class="prx-mat-date">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ \Carbon\Carbon::parse($mat->created_at)->translatedFormat('d M Y') }}
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

@if($photos->count() > 0)
<!-- ── PHOTO GALLERY ── -->
<section id="prx-photo" class="prx-photo-sec" aria-labelledby="prx-photo-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">04</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.prx_visual')</p>
        <h2 class="prx-sec-title" id="prx-photo-h">@lang('site.photogallery')</h2>
      </div>
      <a class="prx-sec-all" href="{{ route('photos') }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    @php $isCarousel = $photos->count() >= 5; @endphp

    @if($isCarousel)
      <div class="prx-photo-carousel" id="prxPhotoCarousel" data-count="{{ $photos->count() }}">
        <div class="prx-photo-track" id="prxPhotoTrack">
          @foreach($photos as $ph)
            @php
              $src   = '/images/galleries/' . $ph->image;
              $title = $ph->getTitleAttribute();
            @endphp
            <a class="prx-photo-slide" href="{{ $src }}" data-caption="{{ $title }}">
              <img src="{{ $src }}" alt="{{ $title }}" loading="lazy">
              <span class="prx-photo-overlay" aria-hidden="true">
                <span class="prx-photo-zoom">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                </span>
                @if($title)
                  <span class="prx-photo-cap">{{ $title }}</span>
                @endif
              </span>
            </a>
          @endforeach
        </div>

        <button type="button" class="prx-photo-nav prx-photo-prev" id="prxPhotoPrev" aria-label="@lang('index.back')">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button type="button" class="prx-photo-nav prx-photo-next" id="prxPhotoNext" aria-label="@lang('index.next')">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

        <div class="prx-photo-dots" id="prxPhotoDots" aria-hidden="true"></div>
      </div>
    @else
      <div class="prx-photo-grid" id="prxPhotoGrid">
        @foreach($photos as $ph)
          @php
            $src   = '/images/galleries/' . $ph->image;
            $title = $ph->getTitleAttribute();
          @endphp
          <a class="prx-photo-tile" href="{{ $src }}" data-caption="{{ $title }}">
            <img src="{{ $src }}" alt="{{ $title }}" loading="lazy">
            <span class="prx-photo-overlay" aria-hidden="true">
              <span class="prx-photo-zoom">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
              </span>
              @if($title)
                <span class="prx-photo-cap">{{ $title }}</span>
              @endif
            </span>
          </a>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endif

@if($videos->count() > 0)
<!-- ── VIDEO GALLERY ── -->
<section id="prx-video" class="prx-video-sec" aria-labelledby="prx-video-h">
  <div class="container">
    <header class="prx-sec-head">
      <span class="prx-sec-num">05</span>
      <div>
        <p class="prx-sec-eyebrow">@lang('site.rdx_vd_live_lib')</p>
        <h2 class="prx-sec-title" id="prx-video-h">@lang('site.videogallery')</h2>
      </div>
      <a class="prx-sec-all" href="{{ route('videos') }}">
        @lang('site.prx_view_all')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    <div class="prx-video-grid">
      @foreach($videos as $vIdx => $v)
        @php
          $vid   = $extractYt($v->video);
          $thumb = $vid ? 'https://i.ytimg.com/vi/' . $vid . '/hqdefault.jpg' : '';
          $embed = $vid ? 'https://www.youtube.com/embed/' . $vid . '?autoplay=1&rel=0&modestbranding=1' : '';
        @endphp
        @if(!$vid) @continue @endif
        <button type="button" class="prx-video-card" data-embed="{{ $embed }}" data-aos="fade-up">
          <span class="prx-video-thumb">
            <img src="{{ $thumb }}" alt="" loading="lazy">
            <span class="prx-video-play" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="6 4 20 12 6 20 6 4"/></svg>
            </span>
          </span>
          <span class="prx-video-meta">
            <span class="prx-video-tag">@lang('site.videogallery')</span>
            <span class="prx-video-num">{{ str_pad($vIdx + 1, 2, '0', STR_PAD_LEFT) }}</span>
          </span>
        </button>
      @endforeach
    </div>
  </div>
</section>

<!-- Video modal -->
<div class="prx-video-modal" id="prxVideoModal" aria-hidden="true" role="dialog">
  <button class="prx-video-modal-close" id="prxVideoClose" aria-label="Close">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>
  <div class="prx-video-modal-inner">
    <div class="prx-video-modal-frame" id="prxVideoFrame"></div>
  </div>
</div>
@endif

@endsection

@push('scripts')
<script>
(function(){
  // Quick-jump tabs active state on scroll
  var tabs = document.querySelectorAll('.prx-tab');
  var sections = ['prx-news','prx-conf','prx-mat','prx-photo','prx-video']
                  .map(function(id){ return document.getElementById(id); })
                  .filter(Boolean);

  function setActive(){
    var y = window.scrollY + 120;
    var current = sections[0];
    sections.forEach(function(s){
      if (s && s.offsetTop <= y) current = s;
    });
    if (!current) return;
    tabs.forEach(function(t){
      t.classList.toggle('is-active', t.getAttribute('href') === '#' + current.id);
    });
  }
  if (sections.length){
    setActive();
    window.addEventListener('scroll', setActive, {passive:true});
  }

  // Photo lightbox (uses BaguetteBox if available, otherwise opens image in new tab via href)
  if (window.baguetteBox) {
    var bbOpts = { animation: 'fadeIn', captions: function(el){ return el.getAttribute('data-caption') || ''; }};
    if (document.getElementById('prxPhotoTrack')) window.baguetteBox.run('#prxPhotoTrack', bbOpts);
    if (document.getElementById('prxPhotoGrid'))  window.baguetteBox.run('#prxPhotoGrid',  bbOpts);
  }

  // Photo carousel
  var track = document.getElementById('prxPhotoTrack');
  if (track) {
    var carousel = document.getElementById('prxPhotoCarousel');
    var prevBtn  = document.getElementById('prxPhotoPrev');
    var nextBtn  = document.getElementById('prxPhotoNext');
    var dotsBox  = document.getElementById('prxPhotoDots');
    var slides   = track.querySelectorAll('.prx-photo-slide');

    function visibleCount(){
      var w = window.innerWidth;
      if (w <= 560)  return 2;
      if (w <= 768)  return 3;
      if (w <= 900)  return 4;
      if (w <= 1024) return 5;
      return 6;
    }
    function pageCount(){
      return Math.max(1, Math.ceil(slides.length / visibleCount()));
    }
    function buildDots(){
      dotsBox.innerHTML = '';
      var total = pageCount();
      for (var i = 0; i < total; i++) {
        var d = document.createElement('button');
        d.type = 'button';
        d.className = 'prx-photo-dot';
        d.setAttribute('data-page', i);
        d.setAttribute('aria-label', 'Page ' + (i+1));
        dotsBox.appendChild(d);
      }
      updateDots();
    }
    function currentPage(){
      var perPage = visibleCount();
      if (!slides.length) return 0;
      var slideW = slides[0].getBoundingClientRect().width + 14; // gap
      return Math.round(track.scrollLeft / (slideW * perPage));
    }
    function updateDots(){
      var cur = currentPage();
      var dots = dotsBox.querySelectorAll('.prx-photo-dot');
      dots.forEach(function(d, i){ d.classList.toggle('is-active', i === cur); });
    }
    function scrollByPages(dir){
      var perPage = visibleCount();
      if (!slides.length) return;
      var slideW = slides[0].getBoundingClientRect().width + 14;
      track.scrollBy({ left: dir * slideW * perPage, behavior: 'smooth' });
    }
    if (prevBtn) prevBtn.addEventListener('click', function(){ scrollByPages(-1); });
    if (nextBtn) nextBtn.addEventListener('click', function(){ scrollByPages(1); });
    track.addEventListener('scroll', function(){ updateDots(); }, {passive:true});
    dotsBox.addEventListener('click', function(e){
      var btn = e.target.closest('.prx-photo-dot');
      if (!btn) return;
      var page = parseInt(btn.getAttribute('data-page'), 10);
      var perPage = visibleCount();
      var slideW = slides[0].getBoundingClientRect().width + 14;
      track.scrollTo({ left: page * slideW * perPage, behavior: 'smooth' });
    });

    // Auto-play
    var autoTimer = null;
    function startAuto(){
      stopAuto();
      autoTimer = setInterval(function(){
        var perPage = visibleCount();
        var slideW = slides[0].getBoundingClientRect().width + 14;
        var maxScroll = track.scrollWidth - track.clientWidth - 4;
        if (track.scrollLeft >= maxScroll) {
          track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
          track.scrollBy({ left: slideW * perPage, behavior: 'smooth' });
        }
      }, 5000);
    }
    function stopAuto(){ if (autoTimer) clearInterval(autoTimer); autoTimer = null; }
    carousel.addEventListener('mouseenter', stopAuto);
    carousel.addEventListener('mouseleave', startAuto);
    carousel.addEventListener('focusin',  stopAuto);
    carousel.addEventListener('focusout', startAuto);
    window.addEventListener('resize', function(){ buildDots(); });

    buildDots();
    startAuto();
  }

  // Video modal
  var modal  = document.getElementById('prxVideoModal');
  var frame  = document.getElementById('prxVideoFrame');
  var closeB = document.getElementById('prxVideoClose');
  var cards  = document.querySelectorAll('.prx-video-card');

  function openVideo(embed){
    if (!modal || !frame) return;
    frame.innerHTML = '<iframe src="' + embed + '" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen frameborder="0"></iframe>';
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden','false');
    document.body.style.overflow = 'hidden';
  }
  function closeVideo(){
    if (!modal || !frame) return;
    frame.innerHTML = '';
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
  }
  cards.forEach(function(c){
    c.addEventListener('click', function(){
      openVideo(this.getAttribute('data-embed'));
    });
  });
  if (closeB) closeB.addEventListener('click', closeVideo);
  if (modal)  modal.addEventListener('click', function(e){ if (e.target === modal) closeVideo(); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeVideo(); });
})();
</script>
@endpush
