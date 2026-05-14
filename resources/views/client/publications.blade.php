@extends('client.layouts.app')

@section('metadata')
  <title>{{ $archive ? $archive->getTitleAttribute() : '' }} | @lang('index.index')</title>
  <meta name="description" content="{{ $archive ? $archive->getMetaDescription() : '' }} | @lang('index.index_des')">
  <meta name="keywords" content="{{ $archive ? $archive->getMetaKeyword() : '' }}">
  <meta property="og:title" content="{{ $archive ? $archive->getTitleAttribute() : '' }} | @lang('index.index')">
  <meta property="og:description" content="{{ $archive ? $archive->getMetaDescription() : '' }} | @lang('index.index_des')">
@endsection

@section('content')
@if($archive)
@php
  // Joriy sahifadagi yozuvlarni yil bo'yicha guruhlash
  $byYear = $items->getCollection()
                  ->groupBy(fn($p) => \Carbon\Carbon::parse($p->created_at)->year)
                  ->sortKeysDesc();
  $years     = $byYear->keys();
  $latestYr  = $items->count() ? \Carbon\Carbon::parse($items->max('created_at'))->year : null;
  $totalPdf  = $items->getCollection()->filter(fn($p) => $p->issetPdf())->count();

  // Yon paneldagi toifalar — faqat publikatsiyalari bor toifalar
  $allArchives = \App\Models\PublicationCategory::orderBy('id', 'asc')->get();
  $archiveCounts = [];
  foreach ($allArchives as $arc) {
    $archiveCounts[$arc->id] = \App\Models\Publication::whereHas('categories',
        function ($q) use ($arc) { $q->where('id', $arc->id); })->count();
  }
@endphp

<!-- ── COMPACT HERO ── -->
<section class="pix-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <a href="{{ route('publications.all') }}">@lang('site.publications')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ $archive->getTitleAttribute() }}</span>
    </nav>

    <div class="pix-hero-row" data-aos="fade-up">
      <div class="pix-hero-info">
        <p class="pix-hero-eyebrow">@lang('site.publications')</p>
        <h1 class="pix-hero-title" id="ph-h">{{ $archive->getTitleAttribute() }}</h1>
        @if($archive->getMetaDescription())
          <p class="pix-hero-sub">{{ $archive->getMetaDescription() }}</p>
        @endif
      </div>

      <ul class="pix-hero-stats" aria-label="@lang('site.arc_metrics')">
        <li>
          <span class="pix-hero-stats-num">{{ $items->total() }}</span>
          <span class="pix-hero-stats-lbl">@lang('site.publications')</span>
        </li>
        <li>
          <span class="pix-hero-stats-num">{{ $totalPdf }}</span>
          <span class="pix-hero-stats-lbl">PDF</span>
        </li>
        <li>
          <span class="pix-hero-stats-num">{{ $latestYr ?: '—' }}</span>
          <span class="pix-hero-stats-lbl">@lang('site.pgs_stat_latest')</span>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- ── ACADEMIC INDEX ── -->
<section id="pix-section" aria-labelledby="pix-h">
  <div class="container">

    <button type="button" class="pix-side-toggle" id="pixSideToggle" aria-expanded="false" aria-controls="pixSide">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      Filter va qidiruv
    </button>

    <div class="pix-shell">
      <!-- SIDEBAR -->
      <aside class="pix-side" id="pixSide" aria-label="@lang('site.arc_categories')">
        <div class="pix-side-inner">

          <div class="pix-search">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="search" id="pixSearch" placeholder="@lang('site.arc_search_placeholder')" aria-label="@lang('site.arc_search_aria')">
          </div>

          <div class="pix-filter">
            <h3 class="pix-filter-h">
              <span class="pix-filter-h-mark"></span>
              @lang('site.arc_categories')
            </h3>
            <ul class="pix-filter-list">
              @foreach($allArchives as $arc)
                @if(!empty($archiveCounts[$arc->id]) && $archiveCounts[$arc->id] > 0)
                  <li>
                    <a href="{{ route('publications', $arc->slug) }}"
                       class="pix-filter-item @if($arc->id === $archive->id) is-active @endif">
                      <span class="pix-filter-mark" aria-hidden="true"></span>
                      <span class="pix-filter-name">{{ $arc->getTitleAttribute() }}</span>
                      <span class="pix-filter-count">{{ $archiveCounts[$arc->id] }}</span>
                    </a>
                  </li>
                @endif
              @endforeach
            </ul>
          </div>

          @if($years->count() > 1)
            <div class="pix-filter">
              <h3 class="pix-filter-h">
                <span class="pix-filter-h-mark"></span>
                @lang('site.rdx_years')
              </h3>
              <ul class="pix-filter-list" id="pixYFilter">
                <li>
                  <button type="button" class="pix-filter-item is-active" data-year="all">
                    <span class="pix-filter-mark" aria-hidden="true"></span>
                    <span class="pix-filter-name">@lang('site.rdx_all')</span>
                    <span class="pix-filter-count">{{ $items->count() }}</span>
                  </button>
                </li>
                @foreach($years as $yr)
                  <li>
                    <button type="button" class="pix-filter-item" data-year="{{ $yr }}">
                      <span class="pix-filter-mark" aria-hidden="true"></span>
                      <span class="pix-filter-name">{{ $yr }}</span>
                      <span class="pix-filter-count">{{ $byYear[$yr]->count() }}</span>
                    </button>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="pix-side-foot">
            <span class="pix-side-foot-lbl">@lang('site.pgs_stat_latest')</span>
            <span class="pix-side-foot-val">{{ $latestYr ?: '—' }}</span>
          </div>
        </div>
      </aside>

      <!-- MAIN -->
      <div class="pix-main">

        <header class="pix-main-toolbar" data-aos="fade-up">
          <div class="pix-toolbar-l">
            <p class="pix-toolbar-eyebrow">@lang('site.publications') · {{ $archive->getTitleAttribute() }}</p>
            <h2 class="pix-toolbar-title" id="pix-h">@lang('site.rdx_registry')</h2>
          </div>
          <div class="pix-toolbar-r">
            <span class="pix-toolbar-count">
              <b id="pixCount">{{ $items->count() }}</b> / {{ $items->total() }}
            </span>
          </div>
        </header>

        @if($items->isEmpty())
          <p class="pix-empty">@lang('site.pgs_empty')</p>
        @endif

        @php $globalIdx = ($items->currentPage() - 1) * $items->perPage(); @endphp
        @foreach($byYear as $yr => $group)
          <section class="pix-yeargroup" data-year="{{ $yr }}" data-aos="fade-up">
            <header class="pix-yearhead">
              <span class="pix-yearhead-num">{{ $yr }}</span>
              <span class="pix-yearhead-line" aria-hidden="true"></span>
              <span class="pix-yearhead-count">{{ $group->count() }} @lang('site.laws_stat_docs')</span>
            </header>

            <ol class="pix-entries">
              @foreach($group as $pub)
                @php
                  $globalIdx++;
                  $dt = \Carbon\Carbon::parse($pub->created_at);
                  $dt->locale(app()->getLocale());

                  $abstract = '';
                  if ($pub->issetDescription()) {
                    $clean = html_entity_decode(strip_tags($pub->getDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $clean = trim(preg_replace('/\s+/u', ' ', $clean));
                    $abstract = \Illuminate\Support\Str::limit($clean, 170);
                  }
                @endphp
                <li class="pix-entry" data-year="{{ $yr }}">
                  <a href="{{ route('publicationItem', [$archive->slug, $pub->slug]) }}" class="pix-entry-link">
                    <div class="pix-entry-num" aria-hidden="true">{{ str_pad($globalIdx, 3, '0', STR_PAD_LEFT) }}</div>

                    <div class="pix-entry-content">
                      <div class="pix-entry-meta">
                        <span class="pix-entry-cat">{{ $archive->getTitleAttribute() }}</span>
                        <span class="pix-entry-dot" aria-hidden="true"></span>
                        <span class="pix-entry-date">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                          {{ $dt->translatedFormat('j F Y') }}
                        </span>
                      </div>

                      <h3 class="pix-entry-title">{{ $pub->getTitleAttribute() }}</h3>

                      @if($abstract)
                        <p class="pix-entry-abstract">{{ $abstract }}</p>
                      @endif

                      <div class="pix-entry-foot">
                        @if(!empty($pub->views))
                          <span class="pix-entry-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            {{ $pub->views }}
                          </span>
                        @endif
                        @if($pub->issetPdf())
                          <span class="pix-entry-tag pix-entry-tag-pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            PDF
                          </span>
                        @endif
                        <span class="pix-entry-cta">
                          @lang('site.read_more')
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                      </div>
                    </div>
                  </a>
                </li>
              @endforeach
            </ol>
          </section>
        @endforeach

        {{-- Pagination --}}
        @if($items->hasPages())
          @php
            $curPage  = $items->currentPage();
            $lastPage = $items->lastPage();
          @endphp
          <nav class="pix-pagination" aria-label="@lang('index.navigation')" data-aos="fade-up">
            <a class="pix-pg-nav {{ $curPage == 1 ? 'is-disabled' : '' }}" href="{{ $curPage > 1 ? $items->url($curPage - 1) : '#' }}" @if($curPage == 1) aria-disabled="true" @endif>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
              <span>@lang('index.back')</span>
            </a>
            <ul class="pix-pg-numbers">
              @for($p = 1; $p <= $lastPage; $p++)
                @if($p == $curPage)
                  <li><span class="pix-pg is-current" aria-current="page">{{ $p }}</span></li>
                @elseif($p == 1 || $p == $lastPage || abs($p - $curPage) <= 2)
                  <li><a class="pix-pg" href="{{ $items->url($p) }}">{{ $p }}</a></li>
                @elseif(abs($p - $curPage) == 3)
                  <li><span class="pix-pg-dots">…</span></li>
                @endif
              @endfor
            </ul>
            <a class="pix-pg-nav {{ $curPage == $lastPage ? 'is-disabled' : '' }}" href="{{ $curPage < $lastPage ? $items->url($curPage + 1) : '#' }}" @if($curPage == $lastPage) aria-disabled="true" @endif>
              <span>@lang('index.next')</span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
          </nav>
        @endif

      </div>
    </div>
  </div>
</section>

@else
<!-- Toifa topilmadi -->
<section class="pix-hero" aria-labelledby="ph-h">
  <div class="container">
    <div class="pix-hero-row">
      <div class="pix-hero-info">
        <h1 class="pix-hero-title" id="ph-h">@lang('site.pgs_not_found')</h1>
        <p class="pix-hero-sub">@lang('site.pgs_not_found_sub')</p>
      </div>
    </div>
  </div>
</section>
@endif
@endsection

@push('scripts')
<script>
(function(){
  var search = document.getElementById('pixSearch');
  var yFilter = document.getElementById('pixYFilter');
  var groups = document.querySelectorAll('.pix-yeargroup');
  var entries = document.querySelectorAll('.pix-entry');
  var countEl = document.getElementById('pixCount');
  var sideToggle = document.getElementById('pixSideToggle');
  var side = document.getElementById('pixSide');

  function applyFilter(){
    var q = (search ? search.value.toLowerCase().trim() : '');
    var yearBtn = yFilter ? yFilter.querySelector('.is-active') : null;
    var year = yearBtn ? yearBtn.getAttribute('data-year') : 'all';

    var visible = 0;
    entries.forEach(function(e){
      var text = e.textContent.toLowerCase();
      var yMatch = (year === 'all' || e.getAttribute('data-year') === year);
      var qMatch = !q || text.indexOf(q) !== -1;
      var show = yMatch && qMatch;
      e.style.display = show ? '' : 'none';
      if(show) visible++;
    });

    // Show/hide entire year groups based on visible children
    groups.forEach(function(g){
      var any = g.querySelectorAll('.pix-entry:not([style*="display: none"])').length;
      g.style.display = any > 0 ? '' : 'none';
    });

    if(countEl) countEl.textContent = visible;
  }

  if(search) search.addEventListener('input', applyFilter);

  if(yFilter){
    yFilter.addEventListener('click', function(e){
      var btn = e.target.closest('.pix-filter-item');
      if(!btn) return;
      yFilter.querySelectorAll('.pix-filter-item').forEach(function(b){ b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      applyFilter();
    });
  }

  if(sideToggle && side){
    sideToggle.addEventListener('click', function(){
      var open = side.classList.toggle('is-open');
      sideToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }
})();
</script>
@endpush
