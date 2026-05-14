@extends('client.layouts.app')

@section('metadata')
  <title>@lang('site.photogallery') | @lang('index.index')</title>
  <meta name="description" content="@lang('site.photogallery') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('site.photogallery')">
  <meta property="og:title" content="@lang('site.photogallery') | @lang('index.index')">
  <meta property="og:description" content="@lang('site.photogallery') | @lang('index.index_des')">
@endsection

@section('content')
@php
  $count = is_countable($items) ? count($items) : 0;
  $valid = collect($items)->filter(fn($i) => !empty($i->image))->values();
@endphp

<!-- ── HERO ── -->
<section class="phx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.photogallery')</span>
    </nav>

    <div class="phx-hero-row" data-aos="fade-up">
      <div class="phx-hero-l">
        <p class="phx-hero-eyebrow">
          <span class="phx-hero-aperture" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M14.31 8l5.74 9.94"/><path d="M9.69 8h11.48"/><path d="M7.38 12l5.74-9.94"/><path d="M9.69 16L3.95 6.06"/><path d="M14.31 16H2.83"/><path d="M16.62 12l-5.74 9.94"/></svg>
          </span>
          @lang('site.press')
        </p>
        <h1 class="phx-hero-title" id="ph-h">@lang('site.photogallery')</h1>
        <p class="phx-hero-sub">@lang('site.rdx_intro_photos')</p>
        <div class="phx-hero-tags">
          <span class="phx-hero-tag">{{ $count }} @lang('site.rdx_frames')</span>
          <span class="phx-hero-tag">HD</span>
          <span class="phx-hero-tag">Lightbox</span>
        </div>
      </div>

      <!-- Decorative film strip -->
      <div class="phx-hero-r" aria-hidden="true">
        <div class="phx-filmstrip">
          @for($i = 0; $i < 6; $i++)
            <div class="phx-film-cell">
              @if(isset($valid[$i]) && !empty($valid[$i]->image))
                <img src="/images/galleries/{{ $valid[$i]->image }}" alt="" loading="lazy">
              @endif
            </div>
          @endfor
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── MOSAIC GALLERY ── -->
<section class="phx-gallery-sec" aria-labelledby="pg-h">
  <div class="container">
    <header class="phx-gallery-head" data-aos="fade-up">
      <span class="phx-gallery-corner phx-corner-tl" aria-hidden="true"></span>
      <span class="phx-gallery-corner phx-corner-tr" aria-hidden="true"></span>
      <span class="phx-gallery-corner phx-corner-bl" aria-hidden="true"></span>
      <span class="phx-gallery-corner phx-corner-br" aria-hidden="true"></span>
      <p class="phx-gallery-eyebrow">@lang('site.photogallery')</p>
      <h2 class="phx-gallery-title" id="pg-h">@lang('site.rdx_initiatives')</h2>
    </header>

    @if($count > 0)
      <div class="phx-mosaic" id="phx-mosaic">
        @foreach($items as $idx => $item)
          @php
            if(empty($item->image)) continue;
            $src   = '/images/galleries/' . $item->image;
            $title = method_exists($item, 'getTitleAttribute') ? $item->getTitleAttribute() : '';
            $note  = method_exists($item, 'getAntonationAttribute') ? $item->getAntonationAttribute() : '';
          @endphp
          <a class="phx-tile"
             href="{{ $src }}"
             data-index="{{ $idx }}"
             data-title="{{ $title }}"
             data-note="{{ $note }}"
             aria-label="{{ $title ?: 'Photo ' . ($idx + 1) }}">
            <div class="phx-tile-frame">
              <img class="phx-tile-img" src="{{ $src }}" alt="{{ $title }}" loading="lazy">
              <span class="phx-tile-num" aria-hidden="true">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="phx-tile-cap">
              <div class="phx-tile-cap-inner">
                @if($title)
                  <h3 class="phx-tile-title">{{ $title }}</h3>
                @endif
                @if($note)
                  <p class="phx-tile-note">{{ $note }}</p>
                @endif
              </div>
              <span class="phx-tile-zoom" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
              </span>
            </div>
          </a>
        @endforeach
      </div>
    @else
      <p style="text-align:center;color:var(--t2);padding:3rem 0">@lang('site.pgs_empty')</p>
    @endif
  </div>
</section>

<!-- ── LIGHTBOX ── -->
<div class="ph-lightbox" id="phLightbox" role="dialog" aria-modal="true" aria-hidden="true" aria-label="@lang('site.photogallery')">
  <button type="button" class="ph-lb-close" aria-label="Close">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>
  <button type="button" class="ph-lb-nav ph-lb-prev" aria-label="Previous">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
  </button>
  <button type="button" class="ph-lb-nav ph-lb-next" aria-label="Next">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
  </button>
  <figure class="ph-lb-stage">
    <img class="ph-lb-img" src="" alt="">
    <figcaption class="ph-lb-cap">
      <span class="ph-lb-title"></span>
      <span class="ph-lb-note"></span>
      <span class="ph-lb-counter"></span>
    </figcaption>
  </figure>
</div>

@endsection

@push('scripts')
<script>
(function(){
  var grid    = document.getElementById('phx-mosaic');
  var lb      = document.getElementById('phLightbox');
  if(!grid || !lb) return;

  var cards   = Array.prototype.slice.call(grid.querySelectorAll('.phx-tile'));
  var imgEl   = lb.querySelector('.ph-lb-img');
  var titleEl = lb.querySelector('.ph-lb-title');
  var noteEl  = lb.querySelector('.ph-lb-note');
  var countEl = lb.querySelector('.ph-lb-counter');
  var btnPrev = lb.querySelector('.ph-lb-prev');
  var btnNext = lb.querySelector('.ph-lb-next');
  var btnClose= lb.querySelector('.ph-lb-close');
  var current = 0;

  function open(i){
    current = (i + cards.length) % cards.length;
    var el = cards[current];
    var src = el.getAttribute('href');
    imgEl.src = src;
    imgEl.alt = el.getAttribute('data-title') || '';
    titleEl.textContent = el.getAttribute('data-title') || '';
    noteEl.textContent  = el.getAttribute('data-note') || '';
    countEl.textContent = (current + 1) + ' / ' + cards.length;
    lb.classList.add('is-open');
    lb.setAttribute('aria-hidden','false');
    document.body.style.overflow = 'hidden';
  }
  function close(){
    lb.classList.remove('is-open');
    lb.setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
    imgEl.src = '';
  }
  function next(){ open(current + 1); }
  function prev(){ open(current - 1); }

  cards.forEach(function(card, i){
    card.addEventListener('click', function(e){
      e.preventDefault();
      open(i);
    });
  });

  btnClose.addEventListener('click', close);
  btnNext.addEventListener('click', next);
  btnPrev.addEventListener('click', prev);
  lb.addEventListener('click', function(e){
    if(e.target === lb) close();
  });

  document.addEventListener('keydown', function(e){
    if(!lb.classList.contains('is-open')) return;
    if(e.key === 'Escape') close();
    else if(e.key === 'ArrowRight') next();
    else if(e.key === 'ArrowLeft') prev();
  });

  // Touch swipe
  var tx = 0;
  lb.addEventListener('touchstart', function(e){ tx = e.touches[0].clientX; }, {passive:true});
  lb.addEventListener('touchend', function(e){
    var dx = e.changedTouches[0].clientX - tx;
    if(Math.abs(dx) > 60){ dx < 0 ? next() : prev(); }
  });
})();
</script>
@endpush
