@extends('client.layouts.app')

@section('content')
@php
  $earliestYear = $laws->count() ? \Carbon\Carbon::parse($laws->min('created_at'))->year : null;
  $latestYear   = $laws->count() ? \Carbon\Carbon::parse($laws->max('created_at'))->year : null;

  // Yillar bo'yicha guruh (filter uchun)
  $byYear = $laws->groupBy(fn($l) => \Carbon\Carbon::parse($l->created_at)->year)->sortKeysDesc();
  $years  = $byYear->keys();

  // Boshqa toifalar
  $allCats = \App\Models\LawCategory::orderBy('id', 'asc')->get();
@endphp

@if($category)
<!-- ── HERO ── -->
<section class="lwx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="@lang('site.laws_breadcrumb_aria')">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ $category->getTitleAttribute() }}</span>
    </nav>

    <div class="lwx-hero-row" data-aos="fade-up">
      <div class="lwx-hero-l">
        <p class="lwx-hero-eyebrow">@lang('site.laws_eyebrow')</p>
        <h1 class="lwx-hero-title" id="ph-h">{{ $category->getTitleAttribute() }}</h1>
        @if($category->getDescriptionAttribute())
          <p class="lwx-hero-sub">{{ $category->getDescriptionAttribute() }}</p>
        @endif
      </div>
      <aside class="lwx-seal" aria-hidden="true">
        <div class="lwx-seal-ring lwx-seal-ring-1"></div>
        <div class="lwx-seal-ring lwx-seal-ring-2"></div>
        <div class="lwx-seal-core">
          <span class="lwx-seal-letters">IMRS</span>
          <span class="lwx-seal-num">{{ $laws->count() }}</span>
          <span class="lwx-seal-lbl">@lang('site.laws_stat_docs')</span>
        </div>
      </aside>
    </div>
  </div>
</section>

<!-- ── REGISTRY BANNER ── -->
<section class="lwx-banner-sec" aria-label="Registry stats">
  <div class="container">
    <div class="lwx-banner" data-aos="fade-up">
      <div class="lwx-banner-stamp">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
      </div>
      <div class="lwx-banner-text">
        <p class="lwx-banner-eyebrow">@lang('site.laws_section_label')</p>
        <h2 class="lwx-banner-title">@lang('site.laws_section_title')</h2>
      </div>
      <div class="lwx-banner-stats">
        <div class="lwx-stat">
          <span class="lwx-stat-num">{{ $laws->count() }}</span>
          <span class="lwx-stat-lbl">@lang('site.laws_stat_docs')</span>
        </div>
        <div class="lwx-stat">
          <span class="lwx-stat-num">{{ $earliestYear ?: '—' }}</span>
          <span class="lwx-stat-lbl">@lang('site.laws_stat_earliest')</span>
        </div>
        <div class="lwx-stat">
          <span class="lwx-stat-num">{{ $latestYear ?: '—' }}</span>
          <span class="lwx-stat-lbl">@lang('site.laws_stat_latest')</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── REGISTRY TABLE ── -->
<section class="lwx-registry-sec" aria-labelledby="docs-h">
  <div class="container">
    <h2 class="lwx-sr-h" id="docs-h" style="position:absolute;left:-9999px">{{ $category->getTitleAttribute() }}</h2>

    <!-- Toolbar: categories tabs + search + year filter -->
    <div class="lwx-tools" data-aos="fade-up">
      <div class="lwx-cats">
        @foreach($allCats as $cat)
          <a class="lwx-cat @if($cat->id === $category->id) is-active @endif"
             href="{{ route('laws', $cat->slug) }}">
            <span class="lwx-cat-mark" aria-hidden="true"></span>
            <span class="lwx-cat-name">{{ $cat->getTitleAttribute() }}</span>
          </a>
        @endforeach
      </div>

      <div class="lwx-tools-r">
        @if($years->count() > 1)
          <div class="lwx-yfilter" id="lwxYFilter">
            <button type="button" class="lwx-yf-btn is-active" data-year="all">@lang('site.rdx_all')</button>
            @foreach($years as $yr)
              <button type="button" class="lwx-yf-btn" data-year="{{ $yr }}">{{ $yr }}</button>
            @endforeach
          </div>
        @endif

        <div class="lwx-search">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="search" placeholder="@lang('site.laws_search_placeholder')" aria-label="@lang('site.laws_search_aria')" id="lwxSearch">
        </div>
      </div>
    </div>

    @if($laws->count() > 0)
      <!-- Table-like rows -->
      <div class="lwx-table" id="lwxTable" data-aos="fade-up">
        <header class="lwx-thead" aria-hidden="true">
          <span class="lwx-th lwx-th-num">№</span>
          <span class="lwx-th lwx-th-date">@lang('site.pgs_meta_date')</span>
          <span class="lwx-th lwx-th-title">@lang('site.laws_section_title')</span>
          <span class="lwx-th lwx-th-source">@lang('site.laws_stat_source')</span>
          <span class="lwx-th lwx-th-act"></span>
        </header>

        <ol class="lwx-rows">
          @foreach($laws as $idx => $law)
            @php
              $url = $law->getUrlAttribute();
              if(!$url) { $url = '#'; }
              elseif(!preg_match('~^https?://~i', $url)) { $url = '/' . ltrim($url, '/'); }

              $dt = \Carbon\Carbon::parse($law->created_at);
              $dt->locale(app()->getLocale());
            @endphp
            <li class="lwx-row" data-year="{{ $dt->format('Y') }}">
              <a class="lwx-row-link" href="{{ $url }}" target="_blank" rel="noopener">
                <div class="lwx-cell lwx-cell-num">
                  <span class="lwx-num-prefix">№</span>
                  <span class="lwx-num-val">{{ str_pad($idx + 1, 3, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="lwx-cell lwx-cell-date">
                  <span class="lwx-date-day">{{ $dt->format('d') }}</span>
                  <span class="lwx-date-mon">{{ $dt->translatedFormat('M') }}</span>
                  <span class="lwx-date-year">{{ $dt->format('Y') }}</span>
                </div>

                <div class="lwx-cell lwx-cell-title">
                  <span class="lwx-cat-tag">{{ $category->getTitleAttribute() }}</span>
                  <h3 class="lwx-title">{{ $law->getTitleAttribute() }}</h3>
                  <span class="lwx-doc-no">№ {{ $law->id }}</span>
                </div>

                <div class="lwx-cell lwx-cell-source">
                  <span class="lwx-source-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    lex.uz
                  </span>
                </div>

                <div class="lwx-cell lwx-cell-act">
                  <span class="lwx-arrow" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </span>
                </div>
              </a>
            </li>
          @endforeach
        </ol>
      </div>

      <p class="lwx-empty-msg" id="lwxEmpty" style="display:none">@lang('site.laws_empty')</p>
    @else
      <p class="lwx-empty-msg">@lang('site.laws_empty')</p>
    @endif
  </div>
</section>

@else
<!-- Toifa topilmadi -->
<section class="lwx-hero">
  <div class="container">
    <div class="lwx-hero-row">
      <div class="lwx-hero-l">
        <h1 class="lwx-hero-title">@lang('site.laws_not_found')</h1>
        <p class="lwx-hero-sub">@lang('site.laws_not_found_sub')</p>
      </div>
    </div>
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function(){
  var search = document.getElementById('lwxSearch');
  var yFilter = document.getElementById('lwxYFilter');
  var table = document.getElementById('lwxTable');
  var emptyMsg = document.getElementById('lwxEmpty');
  if(!table) return;
  var rows = table.querySelectorAll('.lwx-row');

  function applyFilter(){
    var q = search ? search.value.toLowerCase().trim() : '';
    var yearBtn = yFilter ? yFilter.querySelector('.is-active') : null;
    var year = yearBtn ? yearBtn.getAttribute('data-year') : 'all';

    var visible = 0;
    rows.forEach(function(row){
      var text = row.textContent.toLowerCase();
      var yMatch = (year === 'all' || row.getAttribute('data-year') === year);
      var qMatch = !q || text.indexOf(q) !== -1;
      var show = yMatch && qMatch;
      row.style.display = show ? '' : 'none';
      if(show) visible++;
    });

    if(emptyMsg){
      emptyMsg.style.display = visible === 0 ? '' : 'none';
    }
  }

  if(search) search.addEventListener('input', applyFilter);
  if(yFilter){
    yFilter.addEventListener('click', function(e){
      var btn = e.target.closest('.lwx-yf-btn');
      if(!btn) return;
      yFilter.querySelectorAll('.lwx-yf-btn').forEach(function(b){ b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      applyFilter();
    });
  }
})();
</script>
@endpush
