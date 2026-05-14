@extends('client.layouts.app')

@section('metadata')
  <title>@lang('site.videogallery') | @lang('index.index')</title>
  <meta name="description" content="@lang('site.videogallery') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('site.videogallery')">
  <meta property="og:title" content="@lang('site.videogallery') | @lang('index.index')">
  <meta property="og:description" content="@lang('site.videogallery') | @lang('index.index_des')">
@endsection

@section('content')
@php
  $count = is_countable($items) ? count($items) : 0;

  // YouTube ID extractor
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

  $coll = collect($items);
  $featured = $coll->first();
  $rowItems = $coll->slice(1, 8);
  $gridItems = $coll->slice(9);

  $featYtId = $featured ? $extractYt($featured->video) : null;
  $featThumb = $featYtId ? 'https://i.ytimg.com/vi/' . $featYtId . '/maxresdefault.jpg' : '';
  $featEmbed = $featYtId
                ? 'https://www.youtube.com/embed/' . $featYtId . '?autoplay=1&rel=0&modestbranding=1'
                : ($featured ? $featured->video . '?autoplay=1&rel=0' : '');
@endphp

<!-- ── CINEMATIC HERO ── -->
<section class="vdx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb vdx-breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.videogallery')</span>
    </nav>

    <div class="vdx-hero-content" data-aos="fade-up">
      <p class="vdx-hero-eyebrow">
        <span class="vdx-rec-dot" aria-hidden="true"></span>
        @lang('site.press') · @lang('site.rdx_vd_live_lib')
      </p>
      <h1 class="vdx-hero-title" id="ph-h">@lang('site.videogallery')</h1>
      <p class="vdx-hero-sub">@lang('site.rdx_intro_videos')</p>

      <div class="vdx-hero-stats">
        <div class="vdx-stat"><b>{{ $count }}</b><span>@lang('site.videogallery')</span></div>
        <div class="vdx-stat"><b>HD</b><span>YouTube</span></div>
        <div class="vdx-stat"><b>16:9</b><span>@lang('site.rdx_vd_aspect')</span></div>
      </div>
    </div>
  </div>
</section>

@if($featured && $featYtId)
<!-- ── SPOTLIGHT (cinematic featured) ── -->
<section class="vdx-spotlight-sec" aria-label="Spotlight video">
  <div class="container">
    <button type="button" class="vdx-spotlight" data-embed="{{ $featEmbed }}" data-aos="fade-up">
      <div class="vdx-spot-bg" style="--bg-img:url('{{ $featThumb }}')" aria-hidden="true"></div>
      <div class="vdx-spot-inner">
        <div class="vdx-spot-badge">
          <span class="vdx-spot-badge-dot" aria-hidden="true"></span>
          @lang('site.arc_featured_tag')
        </div>
        <h2 class="vdx-spot-title">{{ $featured->getTitleAttribute ?? 'IMRS Featured' }}</h2>
        <div class="vdx-spot-cta">
          <span class="vdx-spot-play">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="6,4 22,12 6,20"/></svg>
          </span>
          <span class="vdx-spot-cta-text">@lang('site.rdx_w_watch')</span>
        </div>
        <span class="vdx-spot-corner vdx-corner-tl" aria-hidden="true"></span>
        <span class="vdx-spot-corner vdx-corner-tr" aria-hidden="true"></span>
        <span class="vdx-spot-corner vdx-corner-bl" aria-hidden="true"></span>
        <span class="vdx-spot-corner vdx-corner-br" aria-hidden="true"></span>
      </div>
    </button>
  </div>
</section>
@endif

@if($rowItems->count() > 0)
<!-- ── ROW: LATEST ── -->
<section class="vdx-row-sec" aria-label="@lang('site.pgs_stat_latest')">
  <div class="container">
    <header class="vdx-row-head">
      <p class="vdx-row-eyebrow">@lang('site.press')</p>
      <h2 class="vdx-row-title">@lang('site.pgs_stat_latest')</h2>
      <div class="vdx-row-nav" aria-hidden="true">
        <button type="button" class="vdx-row-btn" data-dir="-1" aria-label="Previous">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button type="button" class="vdx-row-btn" data-dir="1" aria-label="Next">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>
    </header>

    <div class="vdx-row" data-row>
      <div class="vdx-row-track">
        @foreach($rowItems as $idx => $item)
          @php
            $ytId  = $extractYt($item->video);
            $thumb = $ytId ? 'https://i.ytimg.com/vi/' . $ytId . '/hqdefault.jpg' : '';
            $embed = $ytId
                      ? 'https://www.youtube.com/embed/' . $ytId . '?autoplay=1&rel=0&modestbranding=1'
                      : ($item->video . '?autoplay=1&rel=0');
          @endphp
          <button type="button" class="vdx-tile" data-embed="{{ $embed }}" aria-label="Play video {{ $idx + 2 }}">
            <div class="vdx-tile-thumb">
              @if($thumb)
                <img src="{{ $thumb }}" alt="" loading="lazy"
                     onerror="this.onerror=null;this.src='https://i.ytimg.com/vi/{{ $ytId }}/mqdefault.jpg';">
              @endif
              <span class="vdx-tile-grade" aria-hidden="true"></span>
              <span class="vdx-tile-play">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="6,4 22,12 6,20"/></svg>
              </span>
              <span class="vdx-tile-tc" aria-hidden="true">▌▌</span>
            </div>
            <div class="vdx-tile-meta">
              <span class="vdx-tile-num">№ {{ str_pad($idx + 2, 2, '0', STR_PAD_LEFT) }}</span>
              <span class="vdx-tile-dot" aria-hidden="true"></span>
              <span class="vdx-tile-yt">YouTube · HD</span>
            </div>
          </button>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

@if($gridItems->count() > 0)
<!-- ── GRID: LIBRARY ── -->
<section class="vdx-grid-sec" aria-label="@lang('site.rdx_vd_library')">
  <div class="container">
    <header class="vdx-row-head">
      <p class="vdx-row-eyebrow">@lang('site.rdx_vd_library')</p>
      <h2 class="vdx-row-title">@lang('site.videogallery')</h2>
    </header>

    <div class="vdx-grid">
      @foreach($gridItems as $idx => $item)
        @php
          $ytId  = $extractYt($item->video);
          $thumb = $ytId ? 'https://i.ytimg.com/vi/' . $ytId . '/hqdefault.jpg' : '';
          $embed = $ytId
                    ? 'https://www.youtube.com/embed/' . $ytId . '?autoplay=1&rel=0&modestbranding=1'
                    : ($item->video . '?autoplay=1&rel=0');
          $absIdx = $idx + 10;
        @endphp
        <button type="button" class="vdx-tile" data-embed="{{ $embed }}" aria-label="Play video {{ $absIdx }}">
          <div class="vdx-tile-thumb">
            @if($thumb)
              <img src="{{ $thumb }}" alt="" loading="lazy"
                   onerror="this.onerror=null;this.src='https://i.ytimg.com/vi/{{ $ytId }}/mqdefault.jpg';">
            @endif
            <span class="vdx-tile-grade" aria-hidden="true"></span>
            <span class="vdx-tile-play">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="6,4 22,12 6,20"/></svg>
            </span>
            <span class="vdx-tile-tc" aria-hidden="true">▌▌</span>
          </div>
          <div class="vdx-tile-meta">
            <span class="vdx-tile-num">№ {{ str_pad($absIdx, 2, '0', STR_PAD_LEFT) }}</span>
            <span class="vdx-tile-dot" aria-hidden="true"></span>
            <span class="vdx-tile-yt">YouTube · HD</span>
          </div>
        </button>
      @endforeach
    </div>
  </div>
</section>
@endif

@if($count === 0)
  <section class="vdx-empty">
    <div class="container">
      <p>@lang('site.pgs_empty')</p>
    </div>
  </section>
@endif

<!-- ── VIDEO LIGHTBOX ── -->
<div class="vd-lightbox" id="vdLightbox" role="dialog" aria-modal="true" aria-hidden="true" aria-label="@lang('site.videogallery')">
  <button type="button" class="vd-lb-close" aria-label="Close">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>
  <button type="button" class="vd-lb-nav vd-lb-prev" aria-label="Previous">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
  </button>
  <button type="button" class="vd-lb-nav vd-lb-next" aria-label="Next">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
  </button>
  <div class="vd-lb-stage">
    <div class="vd-lb-frame">
      <iframe class="vd-lb-iframe" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="vd-lb-counter"></div>
  </div>
</div>

@endsection

@push('scripts')
<script>
(function(){
  // Collect ALL playable elements (spotlight + tiles)
  var all = Array.prototype.slice.call(document.querySelectorAll('.vdx-spotlight, .vdx-tile'));
  if(all.length === 0) return;

  var lb      = document.getElementById('vdLightbox');
  var iframe  = lb ? lb.querySelector('.vd-lb-iframe') : null;
  var counter = lb ? lb.querySelector('.vd-lb-counter') : null;
  var btnPrev = lb ? lb.querySelector('.vd-lb-prev') : null;
  var btnNext = lb ? lb.querySelector('.vd-lb-next') : null;
  var btnClose= lb ? lb.querySelector('.vd-lb-close') : null;
  var current = 0;

  function open(i){
    current = (i + all.length) % all.length;
    var src = all[current].getAttribute('data-embed');
    if(iframe) iframe.src = src;
    if(counter) counter.textContent = (current + 1) + ' / ' + all.length;
    if(lb){
      lb.classList.add('is-open');
      lb.setAttribute('aria-hidden','false');
    }
    document.body.style.overflow = 'hidden';
  }
  function close(){
    if(iframe) iframe.src = '';
    if(lb){
      lb.classList.remove('is-open');
      lb.setAttribute('aria-hidden','true');
    }
    document.body.style.overflow = '';
  }
  function next(){ open(current + 1); }
  function prev(){ open(current - 1); }

  all.forEach(function(el, i){
    el.addEventListener('click', function(){ open(i); });
  });
  if(btnClose) btnClose.addEventListener('click', close);
  if(btnNext)  btnNext.addEventListener('click', next);
  if(btnPrev)  btnPrev.addEventListener('click', prev);
  if(lb) lb.addEventListener('click', function(e){ if(e.target === lb) close(); });

  document.addEventListener('keydown', function(e){
    if(!lb || !lb.classList.contains('is-open')) return;
    if(e.key === 'Escape') close();
    else if(e.key === 'ArrowRight') next();
    else if(e.key === 'ArrowLeft') prev();
  });

  // Touch swipe
  if(lb){
    var tx = 0;
    lb.addEventListener('touchstart', function(e){ tx = e.touches[0].clientX; }, {passive:true});
    lb.addEventListener('touchend', function(e){
      var dx = e.changedTouches[0].clientX - tx;
      if(Math.abs(dx) > 60){ dx < 0 ? next() : prev(); }
    });
  }

  // Row carousel scroll buttons
  document.querySelectorAll('.vdx-row-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
      var dir = parseInt(btn.getAttribute('data-dir'), 10) || 1;
      var row = btn.closest('.vdx-row-sec').querySelector('.vdx-row');
      if(!row) return;
      var first = row.querySelector('.vdx-tile');
      var step = first ? (first.offsetWidth + 18) : 280;
      row.scrollBy({ left: step * 2 * dir, behavior: 'smooth' });
    });
  });

  // Drag scroll for rows
  document.querySelectorAll('[data-row]').forEach(function(row){
    var down = false, sx, sl;
    row.addEventListener('mousedown', function(e){ down = true; sx = e.pageX - row.offsetLeft; sl = row.scrollLeft; row.classList.add('is-grabbing'); });
    row.addEventListener('mouseleave', function(){ down = false; row.classList.remove('is-grabbing'); });
    row.addEventListener('mouseup',    function(){ down = false; row.classList.remove('is-grabbing'); });
    row.addEventListener('mousemove', function(e){
      if(!down) return;
      e.preventDefault();
      var x = e.pageX - row.offsetLeft;
      row.scrollLeft = sl - (x - sx) * 1.2;
    });
  });
})();
</script>
@endpush
