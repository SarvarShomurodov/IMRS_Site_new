@extends('client.layouts.app')

@section('metadata')
  <title>@lang('index.journals') | @lang('index.index')</title>
  <meta name="description" content="@lang('index.journals') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.journals')">
  <meta property="og:title" content="@lang('index.journals') | @lang('index.index')">
  <meta property="og:description" content="@lang('index.journals') | @lang('index.index_des')">
@endsection

@section('content')
@php
  $count    = is_countable($journals) ? count($journals) : 0;
  $featured = $count > 0 ? $journals[0] : null;
  $rest     = $count > 1 ? array_slice($journals, 1) : [];
  $latestYr = $featured ? \Carbon\Carbon::parse($featured->created_at)->year : null;
  $issn     = $featured && !empty($featured->issn) ? $featured->issn : null;

  // Book cover spine colors palette (cycle)
  $palette = [
    ['#1a4a7a','#2563a8'], // blue dark
    ['#7a4a1a','#a87a25'], // brown amber
    ['#3a4a5a','#5a7a9a'], // grey blue
    ['#4a1a5a','#7a25a8'], // purple
    ['#1a5a4a','#258a6a'], // green
  ];
@endphp

<!-- ── HERO ── -->
<section class="jrx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('index.journals')</span>
    </nav>

    <div class="jrx-hero-row" data-aos="fade-up">
      <div class="jrx-hero-l">
        <p class="jrx-hero-eyebrow">@lang('site.journal') @if($issn) · ISSN {{ $issn }} @endif</p>
        <h1 class="jrx-hero-title" id="ph-h">@lang('index.journals')</h1>
        <p class="jrx-hero-sub">@lang('site.rdx_intro_journal')</p>
      </div>
      <div class="jrx-hero-r">
        <div class="jrx-hero-stat"><b>{{ $count }}</b><span>@lang('index.journals')</span></div>
        <div class="jrx-hero-stat"><b>{{ $latestYr ?: '—' }}</b><span>@lang('site.pgs_stat_latest')</span></div>
      </div>
    </div>
  </div>
</section>

@if($featured)
<!-- ── FEATURED ISSUE (3D book + side info) ── -->
<section class="jrx-feat-sec" aria-label="@lang('site.arc_featured_tag')">
  <div class="container">
    <div class="jrx-feat" data-aos="fade-up">
      <a class="jrx-feat-cover-wrap" href="{{ route('journal.archive', $featured->id) }}" aria-label="{{ $featured->getTitleAttribute() }}">
        <div class="jrx-book jrx-book-lg">
          <div class="jrx-book-cover">
            @if($featured->image)
              <img src="{{ asset('images/journals/' . $featured->image) }}" alt="{{ $featured->getTitleAttribute() }}" loading="lazy" onerror="this.parentElement.classList.add('is-fallback')">
            @else
              <div class="jrx-book-fallback">
                <span class="jrx-book-fb-letters">IMRS</span>
                <span class="jrx-book-fb-num">№{{ $featured->id }}</span>
                <span class="jrx-book-fb-time">{{ $featured->getTimeAttribute() }}</span>
              </div>
            @endif
            <span class="jrx-book-glare" aria-hidden="true"></span>
          </div>
          <div class="jrx-book-spine" aria-hidden="true"></div>
          <div class="jrx-book-pages" aria-hidden="true"></div>
        </div>
      </a>

      <div class="jrx-feat-body">
        <span class="jrx-feat-tag">
          <span class="jrx-feat-tag-dot" aria-hidden="true"></span>
          @lang('site.arc_featured_tag')
        </span>
        <p class="jrx-feat-num">№ {{ $featured->id }}</p>
        <h2 class="jrx-feat-title">{{ $featured->getTitleAttribute() }}</h2>
        <p class="jrx-feat-period">{{ $featured->getTimeAttribute() }}</p>

        <ul class="jrx-feat-meta">
          @if(!empty($featured->issn))
            <li>
              <span class="jrx-feat-meta-lbl">ISSN</span>
              <span class="jrx-feat-meta-val">{{ $featured->issn }}</span>
            </li>
          @endif
          @if(!empty($featured->views))
            <li>
              <span class="jrx-feat-meta-lbl">@lang('site.views')</span>
              <span class="jrx-feat-meta-val">{{ $featured->views }}</span>
            </li>
          @endif
          @if(!empty($featured->journal))
            <li>
              <span class="jrx-feat-meta-lbl">@lang('site.rdx_format')</span>
              <span class="jrx-feat-meta-val">PDF</span>
            </li>
          @endif
        </ul>

        <a class="jrx-feat-cta" href="{{ route('journal.archive', $featured->id) }}">
          <span>@lang('site.read_journal')</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>
@endif

@if(count($rest) > 0)
<!-- ── BOOKSHELF ARCHIVE (horizontal scroll) ── -->
<section class="jrx-shelf-sec" aria-label="@lang('site.pgs_archive_title')">
  <div class="container">
    <header class="jrx-shelf-head" data-aos="fade-up">
      <div>
        <p class="jrx-shelf-eyebrow">@lang('site.pgs_archive_title')</p>
        <h2 class="jrx-shelf-title">@lang('site.pgs_archive_desc')</h2>
      </div>
      <div class="jrx-shelf-nav" aria-hidden="true">
        <button type="button" class="jrx-shelf-nav-btn" id="jrxPrev" aria-label="Previous">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button type="button" class="jrx-shelf-nav-btn" id="jrxNext" aria-label="Next">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>
    </header>

    <div class="jrx-shelf" id="jrxShelf">
      <div class="jrx-shelf-track" id="jrxTrack">
        @foreach($rest as $idx => $journal)
          @php $col = $palette[$idx % count($palette)]; @endphp
          <a class="jrx-book-item" href="{{ route('journal.archive', $journal->id) }}"
             style="--spine-c1:{{ $col[0] }};--spine-c2:{{ $col[1] }}">
            <div class="jrx-book">
              <div class="jrx-book-cover">
                @if($journal->image)
                  <img src="{{ asset('images/journals/' . $journal->image) }}" alt="{{ $journal->getTitleAttribute() }}" loading="lazy" onerror="this.parentElement.classList.add('is-fallback')">
                @else
                  <div class="jrx-book-fallback">
                    <span class="jrx-book-fb-letters">IMRS</span>
                    <span class="jrx-book-fb-num">№{{ $journal->id }}</span>
                    <span class="jrx-book-fb-time">{{ $journal->getTimeAttribute() }}</span>
                  </div>
                @endif
                <span class="jrx-book-glare" aria-hidden="true"></span>
              </div>
              <div class="jrx-book-spine" aria-hidden="true"></div>
              <div class="jrx-book-pages" aria-hidden="true"></div>
            </div>
            <div class="jrx-book-label">
              <span class="jrx-book-num">№ {{ $journal->id }}</span>
              <span class="jrx-book-time">{{ $journal->getTimeAttribute() }}</span>
            </div>
          </a>
        @endforeach
      </div>

      <!-- Wooden shelf base (decorative line) -->
      <div class="jrx-shelf-base" aria-hidden="true"></div>
    </div>

    <p class="jrx-shelf-hint">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22V8"/><path d="m5 12 7-4 7 4"/><path d="M5 12v6l7 4 7-4v-6"/></svg>
      @lang('site.rdx_drag_hint')
    </p>
  </div>
</section>
@endif

@if($count === 0)
  <section class="jrx-empty">
    <div class="container">
      <p>@lang('site.pgs_empty')</p>
    </div>
  </section>
@endif

@endsection

@push('scripts')
<script>
(function(){
  var shelf = document.getElementById('jrxShelf');
  var track = document.getElementById('jrxTrack');
  if(!shelf || !track) return;

  var btnPrev = document.getElementById('jrxPrev');
  var btnNext = document.getElementById('jrxNext');

  function step(){
    var first = track.querySelector('.jrx-book-item');
    if(!first) return 240;
    return first.offsetWidth + 24;
  }

  if(btnPrev) btnPrev.addEventListener('click', function(){
    track.scrollBy({ left: -step() * 2, behavior: 'smooth' });
  });
  if(btnNext) btnNext.addEventListener('click', function(){
    track.scrollBy({ left: step() * 2, behavior: 'smooth' });
  });

  // Drag to scroll
  var isDown = false, startX, scrollLeft;
  track.addEventListener('mousedown', function(e){
    isDown = true;
    track.classList.add('is-grabbing');
    startX = e.pageX - track.offsetLeft;
    scrollLeft = track.scrollLeft;
  });
  track.addEventListener('mouseleave', function(){ isDown = false; track.classList.remove('is-grabbing'); });
  track.addEventListener('mouseup',    function(){ isDown = false; track.classList.remove('is-grabbing'); });
  track.addEventListener('mousemove', function(e){
    if(!isDown) return;
    e.preventDefault();
    var x = e.pageX - track.offsetLeft;
    var walk = (x - startX) * 1.2;
    track.scrollLeft = scrollLeft - walk;
  });

  // Keyboard
  shelf.addEventListener('keydown', function(e){
    if(e.key === 'ArrowRight'){ track.scrollBy({ left: step(), behavior: 'smooth' }); }
    else if(e.key === 'ArrowLeft'){ track.scrollBy({ left: -step(), behavior: 'smooth' }); }
  });
})();
</script>
@endpush
