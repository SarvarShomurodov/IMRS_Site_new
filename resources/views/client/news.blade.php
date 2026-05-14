@extends('client.layouts.app')

@section('metadata')
  <title>{{ $item->getTitleAttribute() }} | @lang('index.index')</title>
  <meta name="description" content="{{ $item->getMetaDescription() }}">
  <meta name="keywords" content="{{ $item->getMetaKeyword() }}">
  <meta property="og:title" content="{{ $item->getTitleAttribute() }} | @lang('index.index')">
  <meta property="og:description" content="{{ $item->getMetaDescription() }}">
  @if($item->issetImage())
    <meta property="og:image" content="{{ url($item->getImageAttribute()) }}">
  @endif
@endsection

@section('content')
@php
  $coverUrl = $item->issetImage() ? $item->getImageAttribute() : '';
  $shortDesc = '';
  if ($item->issetDescription()) {
    $clean = html_entity_decode(strip_tags($item->getDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $clean = preg_replace('/\s+/u', ' ', $clean);
    $shortDesc = \Illuminate\Support\Str::limit(trim($clean), 220);
  }
@endphp

{{-- Reading progress --}}
<div class="nwx-progress" id="nwxProgress" aria-hidden="true"><span></span></div>

{{-- ── HERO ── --}}
<header class="nwx-hero" id="nwxHero" @if($coverUrl) style="--cover:url('{{ $coverUrl }}')" @endif>
  <div class="nwx-hero-bg" aria-hidden="true">
    <div class="nwx-hero-img"></div>
    <div class="nwx-hero-grid"></div>
    <div class="nwx-hero-vignette"></div>
    <div class="nwx-hero-spot" id="nwxSpot"></div>
    <div class="nwx-hero-noise"></div>
  </div>

  <div class="container nwx-hero-inner">
    <nav class="nwx-bc" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
      <a href="{{ route('archives', $archive->slug) }}">{{ $archive->getTitleAttribute() }}</a>
      <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.press')</span>
    </nav>

    <div class="nwx-hero-meta">
      <span class="nwx-chip">
        <i class="dot"></i>
        {{ $archive->getTitleAttribute() }}
      </span>
      <span class="nwx-divider"></span>
      <time class="nwx-time">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F, Y') }}</time>
      @if(!empty($item->views))
        <span class="nwx-divider"></span>
        <span class="nwx-time">{{ $item->views }} {{ __('site.views') }}</span>
      @endif
    </div>

    <h5 class="nwx-hero-title" data-aos="fade-up" data-aos-delay="80">
      {{ $item->getTitleAttribute() }}
    </h5>

    @if($shortDesc)
      <p class="nwx-hero-lede" data-aos="fade-up" data-aos-delay="160">{{ $shortDesc }}</p>
    @endif

    <div class="nwx-stats" data-aos="fade-up" data-aos-delay="240">
      <div class="nwx-stat">
        <span class="nwx-stat-num">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j') }}</span>
        <span class="nwx-stat-lbl">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('F Y') }}</span>
      </div>
      @if(!empty($item->views))
        <div class="nwx-stat">
          <span class="nwx-stat-num">{{ $item->views }}</span>
          <span class="nwx-stat-lbl">@lang('site.views')</span>
        </div>
      @endif
      <div class="nwx-stat">
        <span class="nwx-stat-num">{{ $item->files->count() + ($item->issetPdf() ? 1 : 0) }}</span>
        <span class="nwx-stat-lbl">@lang('site.attached_files')</span>
      </div>
      <div class="nwx-stat">
        <span class="nwx-stat-num">{{ $item->issetVideo() ? '1' : '—' }}</span>
        <span class="nwx-stat-lbl">@lang('site.videogallery')</span>
      </div>
    </div>
  </div>

  <div class="nwx-scroll" aria-hidden="true">
    <span></span>
  </div>
</header>

{{-- ── ARTICLE ── --}}
<section class="nwx-doc" id="nwxDoc" aria-labelledby="art-h">
  <div class="container nwx-doc-grid">
    {{-- Sticky share rail --}}
    <aside class="nwx-share" aria-label="Share">
      <span class="nwx-share-cap">@lang('site.press')</span>
      <div class="nwx-share-list">
        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&amp;text={{ urlencode($item->getTitleAttribute()) }}" target="_blank" rel="noopener" aria-label="Telegram">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.7 3.64 12.4c-.88-.25-.89-.86.2-1.3l16-6.18c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/></svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" aria-label="Facebook">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
        </a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&amp;text={{ urlencode($item->getTitleAttribute()) }}" target="_blank" rel="noopener" aria-label="X / Twitter">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.16 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <button type="button" id="nwxCopy" aria-label="Copy link">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
        </button>
      </div>
    </aside>

    {{-- Body --}}
    <article class="nwx-article">
      @if($item->issetVideo())
        <div class="nwx-video" data-aos="fade-up">
          <iframe src="{{ $item->getVideo() }}?rel=0" title="{{ $item->getTitleAttribute() }}" allowfullscreen loading="lazy"></iframe>
        </div>
      @endif

      @if($item->issetDescription())
        <div class="nwx-body" data-aos="fade-up">
          {!! $item->getDescriptionAttribute() !!}
        </div>
      @endif

      @if($item->issetPdf() || $item->files->count() > 0)
        <aside class="nwx-files" data-aos="fade-up" aria-label="@lang('site.attached_files')">
          <div class="nwx-files-head">
            <span class="nwx-files-rule"></span>
            <h3>@lang('site.attached_files')</h3>
          </div>
          <ul class="nwx-files-list">
            @if($item->issetPdf())
              <li>
                <a href="{{ $item->getPdfAttribute() }}" target="_blank" download>
                  <span class="nwx-f-num">01</span>
                  <span class="nwx-f-info">
                    <span class="nwx-f-name">{{ basename($item->getPdfAttribute()) }}</span>
                    <span class="nwx-f-meta">PDF · @lang('site.download')</span>
                  </span>
                  <span class="nwx-f-arrow"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </a>
              </li>
            @endif
            @foreach($item->files as $f => $file)
              <li>
                <a href="/files/files/{{ $file->file }}" target="_blank" download>
                  <span class="nwx-f-num">{{ str_pad((int)$f + ($item->issetPdf() ? 2 : 1), 2, '0', STR_PAD_LEFT) }}</span>
                  <span class="nwx-f-info">
                    <span class="nwx-f-name">{{ $file->file }}</span>
                    <span class="nwx-f-meta">@lang('site.file') · @lang('site.download')</span>
                  </span>
                  <span class="nwx-f-arrow"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </a>
              </li>
            @endforeach
          </ul>
        </aside>
      @endif
    </article>

    {{-- Sticky meta sidebar --}}
    <aside class="nwx-meta" aria-label="Article info">
      <div class="nwx-meta-card">
        @if($item->issetImage())
          <div class="nwx-meta-cover" style="--c:url('{{ $item->getImageAttribute() }}')"></div>
        @endif
        <span class="nwx-meta-cap">@lang('site.press')</span>
        <h6 class="nwx-meta-title">{{ $archive->getTitleAttribute() }}</h6>
        <ul class="nwx-meta-list">
          <li><span>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}</span><b>—</b></li>
          @if(!empty($item->views))
            <li><span>@lang('site.views')</span><b>{{ $item->views }}</b></li>
          @endif
          <li><span>@lang('site.attached_files')</span><b>{{ $item->files->count() + ($item->issetPdf() ? 1 : 0) }}</b></li>
        </ul>
        <a href="{{ route('archives', $archive->slug) }}" class="nwx-meta-back">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          @lang('site.news_back_all')
        </a>
      </div>
    </aside>
  </div>
</section>

{{-- ── PREV / NEXT ── --}}
@if($item1 || $item2)
<section class="nwx-nav" aria-labelledby="nn-h">
  <div class="container">
    <div class="nwx-nav-head">
      <span class="nwx-eyebrow">@lang('site.news_nav_aria')</span>
      <h2 id="nn-h">@lang('site.news_more_title')</h2>
    </div>

    <div class="nwx-nav-grid @if(!($item1 && $item2)) is-single @endif">
      @if($item1)
        <a class="nwx-nav-card prev" data-tilt href="{{ route('news', [$archive->slug, $item1->slug]) }}">
          <span class="nwx-nav-dir">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            @lang('site.prev')
          </span>
          <div class="nwx-nav-thumb">
            @if($item1->issetImage())
              <img src="{{ $item1->getImageAttribute() }}" alt="" loading="lazy">
            @endif
          </div>
          <h3 class="nwx-nav-title">{{ \Illuminate\Support\Str::limit($item1->getTitleAttribute(), 100) }}</h3>
          <span class="nwx-nav-date">{{ $item1->getCreatedData() }}</span>
        </a>
      @endif

      @if($item2)
        <a class="nwx-nav-card next" data-tilt href="{{ route('news', [$archive->slug, $item2->slug]) }}">
          <span class="nwx-nav-dir">
            @lang('site.next')
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
          </span>
          <div class="nwx-nav-thumb">
            @if($item2->issetImage())
              <img src="{{ $item2->getImageAttribute() }}" alt="" loading="lazy">
            @endif
          </div>
          <h3 class="nwx-nav-title">{{ \Illuminate\Support\Str::limit($item2->getTitleAttribute(), 100) }}</h3>
          <span class="nwx-nav-date">{{ $item2->getCreatedData() }}</span>
        </a>
      @endif
    </div>
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function(){
  // Reading progress
  var bar = document.querySelector('#nwxProgress span');
  var doc = document.getElementById('nwxDoc');
  if(bar && doc){
    var update = function(){
      var rect = doc.getBoundingClientRect();
      var top = window.scrollY + rect.top;
      var max = rect.height - window.innerHeight;
      if(max <= 0){ bar.style.width = '0%'; return; }
      var pct = Math.min(100, Math.max(0, ((window.scrollY - top) / max) * 100));
      bar.style.width = pct + '%';
    };
    window.addEventListener('scroll', update, {passive:true});
    window.addEventListener('resize', update);
    update();
  }

  // Spotlight on hero (flashlight effect)
  var hero = document.getElementById('nwxHero');
  if(hero && !window.matchMedia('(prefers-reduced-motion: reduce)').matches){
    hero.addEventListener('mousemove', function(e){
      var rect = hero.getBoundingClientRect();
      var x = ((e.clientX - rect.left) / rect.width) * 100;
      var y = ((e.clientY - rect.top) / rect.height) * 100;
      hero.style.setProperty('--mx', x + '%');
      hero.style.setProperty('--my', y + '%');
      hero.classList.add('is-active');
    });
    hero.addEventListener('mouseleave', function(){
      hero.classList.remove('is-active');
    });
  }

  // Copy link
  var copy = document.getElementById('nwxCopy');
  if(copy){
    copy.addEventListener('click', function(){
      navigator.clipboard.writeText(location.href).then(function(){
        copy.classList.add('is-done');
        setTimeout(function(){ copy.classList.remove('is-done'); }, 1500);
      });
    });
  }

  // 3D tilt on prev/next cards
  var cards = document.querySelectorAll('[data-tilt]');
  if(cards.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches){
    cards.forEach(function(card){
      card.addEventListener('mousemove', function(e){
        var rect = card.getBoundingClientRect();
        var px = (e.clientX - rect.left) / rect.width;
        var py = (e.clientY - rect.top) / rect.height;
        var rx = (py - 0.5) * -8;
        var ry = (px - 0.5) * 10;
        card.style.transform = 'perspective(900px) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg) translateY(-4px)';
        card.style.setProperty('--mx', (px * 100) + '%');
        card.style.setProperty('--my', (py * 100) + '%');
      });
      card.addEventListener('mouseleave', function(){
        card.style.transform = '';
      });
    });
  }
})();
</script>
@endpush
