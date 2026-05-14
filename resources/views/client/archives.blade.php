@extends('client.layouts.app')

@section('content')
@php
  $coll       = $items->getCollection();
  $featured   = $coll->first();
  $sideLatest = $coll->slice(1, 3);
  $rest       = $coll->slice(4);

  $totalAll  = \App\Models\News::count();
  $latestYr  = optional(\App\Models\News::orderBy('created_at','DESC')->first())->created_at;
  $latestYr  = $latestYr ? \Carbon\Carbon::parse($latestYr)->year : date('Y');

  $featDesc = '';
  if ($featured && $featured->issetDescription()) {
    $featDesc = html_entity_decode(strip_tags($featured->getShortDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $featDesc = trim(preg_replace('/\s+/u', ' ', $featDesc));
  }
@endphp

<!-- ── MAGAZINE MASTHEAD ── -->
<section class="nax-masthead" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ $archive ? $archive->getTitleAttribute() : '' }}</span>
    </nav>

    <div class="nax-masthead-row" data-aos="fade-up">
      <div class="nax-masthead-l">
        <p class="nax-issue-no">@lang('site.press') · {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        <h1 class="nax-masthead-title" id="ph-h">{{ $archive ? $archive->getTitleAttribute() : '' }}</h1>
      </div>
      <div class="nax-masthead-r">
        <span class="nax-mh-rule" aria-hidden="true"></span>
        <p class="nax-masthead-meta">
          <b>{{ $items->total() }}</b> @lang('site.arc_in_category')
          <span class="nax-mh-sep">·</span>
          <b>{{ $latestYr }}</b> @lang('site.pgs_stat_latest')
          <span class="nax-mh-sep">·</span>
          <b>{{ $archives->count() }}</b> @lang('site.arc_categories')
        </p>
      </div>
    </div>
  </div>
</section>

@if($featured)
<!-- ── COVER STORY ── -->
<section class="nax-cover" aria-label="Cover story">
  <div class="container">
    <div class="nax-cover-grid">
      <a class="nax-cover-main" href="{{ route('news', [$archive->slug, $featured->slug]) }}" data-aos="fade-up">
        <div class="nax-cover-img" @if($featured->issetImage()) style="--img:url('{{ $featured->getImageAttribute() }}')" @endif>
          @if($featured->issetImage())
            <img src="{{ $featured->getImageAttribute() }}" alt="{{ $featured->getTitleAttribute() }}" loading="lazy">
          @endif
          <span class="nax-cover-badge">
            <span class="nax-cover-badge-dot" aria-hidden="true"></span>
            @lang('site.arc_featured_tag')
          </span>
          <div class="nax-cover-fold" aria-hidden="true"></div>
        </div>
        <div class="nax-cover-body">
          <p class="nax-cover-cat">{{ $archive->getTitleAttribute() }}</p>
          <h2 class="nax-cover-title">{{ $featured->getTitleAttribute() }}</h2>
          @if($featDesc)
            <p class="nax-cover-desc">{{ $featDesc }}</p>
          @endif
          <div class="nax-cover-foot">
            <span class="nax-cover-date">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              {{ $featured->getCreatedData() }}
            </span>
            @if(!empty($featured->views))
              <span class="nax-cover-views">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                {{ $featured->views }} @lang('site.views')
              </span>
            @endif
            <span class="nax-cover-cta">
              @lang('site.read_more')
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
        </div>
      </a>

      @if($sideLatest->count() > 0)
      <aside class="nax-side" data-aos="fade-left">
        <header class="nax-side-head">
          <span class="nax-side-bullet" aria-hidden="true"></span>
          <h3 class="nax-side-title">@lang('site.pgs_stat_latest')</h3>
        </header>
        <ol class="nax-side-list">
          @foreach($sideLatest as $i => $sn)
            <li>
              <a class="nax-side-item" href="{{ route('news', [$archive->slug, $sn->slug]) }}">
                <span class="nax-side-num">{{ str_pad($i + 2, 2, '0', STR_PAD_LEFT) }}</span>
                <div class="nax-side-text">
                  <h4 class="nax-side-h">{{ $sn->getTitleAttribute() }}</h4>
                  <span class="nax-side-date">{{ $sn->getCreatedData() }}</span>
                </div>
              </a>
            </li>
          @endforeach
        </ol>
        @if($items->total() > 4)
          <a class="nax-side-all" href="#nax-mosaic">
            @lang('site.arc_label')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        @endif
      </aside>
      @endif
    </div>
  </div>
</section>
@endif

<!-- ── TOOLBAR (chips + search) ── -->
<section class="nax-toolbar-sec" aria-label="@lang('site.arc_categories')">
  <div class="container">
    <div class="nax-toolbar" data-aos="fade-up">
      <div class="nax-chips" id="naxChips">
        @foreach($archives as $arc)
          @php
            $arcCount = \App\Models\News::whereHas('categories', function($q) use ($arc){ $q->where('id', $arc->id); })->count();
          @endphp
          <a class="nax-chip @if($archive && $arc->id === $archive->id) is-active @endif"
             href="{{ route('archives', $arc->slug) }}"
             data-cat="{{ $arc->slug }}">
            <span class="nax-chip-name">{{ $arc->getTitleAttribute() }}</span>
            <span class="nax-chip-count">{{ $arcCount }}</span>
          </a>
        @endforeach
      </div>
      <div class="nax-search">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="search" placeholder="@lang('site.arc_search_placeholder')" aria-label="@lang('site.arc_search_aria')" id="naxSearch">
      </div>
    </div>
  </div>
</section>

@if($rest->count() > 0)
<!-- ── MOSAIC GRID ── -->
<section id="nax-mosaic" class="nax-mosaic-sec" aria-labelledby="nm-h">
  <div class="container">
    <header class="nax-mosaic-head">
      <span class="nax-mh-num">02</span>
      <div>
        <p class="nax-mh-eyebrow">@lang('site.arc_label')</p>
        <h2 class="nax-mh-title" id="nm-h">@lang('site.arc_title_2')</h2>
      </div>
    </header>

    <div class="nax-mosaic" id="naxGrid">
      @foreach($rest as $idx => $news)
        @php
          $shortDesc = '';
          if ($news->issetDescription()) {
            $sd = html_entity_decode(strip_tags($news->getShortDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $sd = trim(preg_replace('/\s+/u', ' ', $sd));
            $shortDesc = \Illuminate\Support\Str::limit($sd, 120);
          }
        @endphp
        <article class="nax-card" data-aos="fade-up">
          <a class="nax-card-link" href="{{ route('news', [$archive->slug, $news->slug]) }}">
            <div class="nax-card-img" @if($news->issetImage()) style="--img:url('{{ $news->getImageAttribute() }}')" @endif>
              @if($news->issetImage())
                <img src="{{ $news->getImageAttribute() }}" alt="{{ $news->getTitleAttribute() }}" loading="lazy">
              @else
                <div class="nax-card-img-ph" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/></svg>
                </div>
              @endif
              <span class="nax-card-stamp" aria-hidden="true">
                <span class="nax-card-stamp-d">{{ \Carbon\Carbon::parse($news->created_at)->format('d') }}</span>
                <span class="nax-card-stamp-m">{{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('M') }}</span>
              </span>
            </div>
            <div class="nax-card-body">
              <p class="nax-card-cat">{{ $archive->getTitleAttribute() }}</p>
              <h3 class="nax-card-title">{{ $news->getTitleAttribute() }}</h3>
              @if($shortDesc)
                <p class="nax-card-desc">{{ $shortDesc }}</p>
              @endif
              <div class="nax-card-foot">
                <span class="nax-card-date">{{ $news->getCreatedData() }}</span>
                @if(!empty($news->views))
                  <span class="nax-card-views">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    {{ $news->views }}
                  </span>
                @endif
              </div>
            </div>
          </a>
        </article>
      @endforeach
    </div>

    @if($items->lastPage() > 1)
      @php
        $cur  = $items->currentPage();
        $last = $items->lastPage();
      @endphp
      <nav class="nax-pg" aria-label="@lang('site.arc_pagination_aria')" data-aos="fade-up">
        <a class="nax-pg-nav {{ $items->onFirstPage() ? 'is-disabled' : '' }}"
           href="{{ $items->onFirstPage() ? '#' : $items->previousPageUrl() }}"
           @if($items->onFirstPage()) aria-disabled="true" @endif>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          <span>@lang('index.back')</span>
        </a>
        <div class="nax-pg-meter" aria-hidden="true">
          <span class="nax-pg-meter-fill" style="width:{{ ($cur / $last) * 100 }}%"></span>
        </div>
        <span class="nax-pg-info">{{ $cur }} / {{ $last }}</span>
        <a class="nax-pg-nav {{ $items->hasMorePages() ? '' : 'is-disabled' }}"
           href="{{ $items->hasMorePages() ? $items->nextPageUrl() : '#' }}"
           @if(!$items->hasMorePages()) aria-disabled="true" @endif>
          <span>@lang('index.next')</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </nav>
    @endif
  </div>
</section>
@endif

@if($items->isEmpty())
<section class="nax-empty-sec">
  <div class="container">
    <p style="text-align:center;color:var(--t2);padding:3rem 0">@lang('site.arc_empty')</p>
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function(){
  var input = document.getElementById('naxSearch');
  if(!input) return;
  var cards = document.querySelectorAll('#naxGrid .nax-card, .nax-cover-main, .nax-side-item');
  input.addEventListener('input', function(){
    var q = this.value.toLowerCase().trim();
    cards.forEach(function(c){
      var t = c.textContent.toLowerCase();
      c.style.display = (!q || t.indexOf(q) !== -1) ? '' : 'none';
    });
  });
})();
</script>
@endpush
