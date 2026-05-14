@extends('client.layouts.app')

@section('metadata')
  <title>@lang('index.search_for_results'): {{ $query }} | @lang('index.index')</title>
  <meta name="description" content="@lang('index.search_for_results'): {{ $query }} | @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.search_for_results'): {{ $query }}">
  <meta property="og:title" content="@lang('index.search_for_results'): {{ $query }} | @lang('index.index')">
  <meta property="og:description" content="@lang('index.search_for_results'): {{ $query }} | @lang('index.index_des')">
@endsection

@section('content')
@php
  $newsCount = $news->count();
  $pubCount  = $publications->count();
  $lawCount  = $laws->count();
  $totalCount = $newsCount + $pubCount + $lawCount;

  // Helper: highlight query in text
  $highlight = function($text, $q) {
    if (empty($q)) return e($text);
    $escaped = preg_quote($q, '/');
    $text = strip_tags((string)$text);
    return preg_replace('/(' . $escaped . ')/iu', '<mark>$1</mark>', e($text));
  };
@endphp

<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('index.search_for_results')</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.search')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          @lang('index.search_for_results'): <em>{{ $query }}</em>
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          Yangiliklar, nashrlar va huquqiy hujjatlar bo'yicha qidiruv natijalari.
        </p>
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200">
        <div class="stat"><div class="snum"><span>{{ $totalCount }}</span></div><div class="slbl">@lang('index.search_for_results')</div></div>
        <div class="stat"><div class="snum"><span>{{ $newsCount }}</span></div><div class="slbl">@lang('site.news')</div></div>
        <div class="stat"><div class="snum"><span>{{ $pubCount }}</span></div><div class="slbl">@lang('site.publications')</div></div>
        <div class="stat"><div class="snum"><span>{{ $lawCount }}</span></div><div class="slbl">@lang('site.laws_codes')</div></div>
      </aside>
    </div>
  </div>
</section>

<!-- ── SEARCH RESULTS ── -->
<section id="search-results" aria-labelledby="sr-h">
  <div class="container">
    <h2 class="visually-hidden" id="sr-h" style="position:absolute;left:-9999px">@lang('index.search_for_results')</h2>

    <form class="sr-toolbar" action="{{ route('search') }}" method="get" data-aos="fade-up">
      <div class="sr-search">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="search" name="query" id="srInput" value="{{ $query }}" placeholder="@lang('site.search')" autofocus>
      </div>
      <div class="sr-tabs" id="srTabs">
        <button type="button" class="sr-tab act" data-target="all">@lang('site.all') <span class="sr-tab-count">{{ $totalCount }}</span></button>
        <button type="button" class="sr-tab" data-target="news">@lang('site.news') <span class="sr-tab-count">{{ $newsCount }}</span></button>
        <button type="button" class="sr-tab" data-target="pub">@lang('site.publications') <span class="sr-tab-count">{{ $pubCount }}</span></button>
        <button type="button" class="sr-tab" data-target="laws">@lang('site.laws_codes') <span class="sr-tab-count">{{ $lawCount }}</span></button>
      </div>
    </form>

    <div class="sr-summary" data-aos="fade-up">
      @if($totalCount > 0)
        <p>So'rov bo'yicha <b>{{ $totalCount }}</b> ta natija topildi: <span class="sr-q">{{ $query }}</span></p>
      @else
        <p>So'rov bo'yicha hech narsa topilmadi: <span class="sr-q">{{ $query }}</span></p>
      @endif
    </div>

    @if($totalCount === 0)
      <div class="sr-empty" data-aos="fade-up">
        <div class="sr-empty-ico">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <h3>Natija topilmadi</h3>
        <p>Boshqa kalit so'z bilan urinib ko'ring yoki imloni tekshiring.</p>
      </div>
    @endif

    @if($newsCount > 0)
      <div class="sr-section" data-section="news" data-aos="fade-up">
        <div class="sr-section-hdr">
          <h3>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/></svg>
            @lang('site.news')
          </h3>
          <span class="sr-count">{{ $newsCount }}</span>
        </div>
        <div class="sr-list">
          @foreach($news as $item)
            @php
              $cat = $item->categories()->first();
              $href = $cat ? route('news', [$cat->slug, $item->slug]) : '#';
              $desc = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $item->getShortDescriptionAttribute())));
              $desc = \Illuminate\Support\Str::limit($desc, 200);
            @endphp
            <a class="sr-item" href="{{ $href }}">
              <div class="sr-item-body">
                <span class="sr-item-cat">{{ $cat ? $cat->getTitleAttribute() : __('site.news') }}</span>
                <h4 class="sr-item-title">{!! $highlight($item->getTitleAttribute(), $query) !!}</h4>
                @if($desc)
                  <p class="sr-item-desc">{!! $highlight($desc, $query) !!}</p>
                @endif
              </div>
              <span class="sr-item-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endif

    @if($pubCount > 0)
      <div class="sr-section" data-section="pub" data-aos="fade-up">
        <div class="sr-section-hdr">
          <h3>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            @lang('site.publications')
          </h3>
          <span class="sr-count">{{ $pubCount }}</span>
        </div>
        <div class="sr-list">
          @foreach($publications as $item)
            @php
              $cat = $item->categories()->first();
              $href = $cat ? route('publications', [$cat->slug, $item->slug]) : '#';
              $desc = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $item->getShortDescriptionAttribute())));
              $desc = \Illuminate\Support\Str::limit($desc, 200);
            @endphp
            <a class="sr-item" href="{{ $href }}">
              <div class="sr-item-body">
                <span class="sr-item-cat">{{ $cat ? $cat->getTitleAttribute() : __('site.publications') }}</span>
                <h4 class="sr-item-title">{!! $highlight($item->getTitleAttribute(), $query) !!}</h4>
                @if($desc)
                  <p class="sr-item-desc">{!! $highlight($desc, $query) !!}</p>
                @endif
              </div>
              <span class="sr-item-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endif

    @if($lawCount > 0)
      <div class="sr-section" data-section="laws" data-aos="fade-up">
        <div class="sr-section-hdr">
          <h3>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            @lang('site.laws_codes')
          </h3>
          <span class="sr-count">{{ $lawCount }}</span>
        </div>
        <div class="sr-list">
          @foreach($laws as $item)
            @php
              $href = route('laws', $item->slug);
              $desc = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $item->getShortDescriptionAttribute())));
              $desc = \Illuminate\Support\Str::limit($desc, 200);
            @endphp
            <a class="sr-item" href="{{ $href }}">
              <div class="sr-item-body">
                <span class="sr-item-cat">@lang('site.laws_codes')</span>
                <h4 class="sr-item-title">{!! $highlight($item->getTitleAttribute(), $query) !!}</h4>
                @if($desc)
                  <p class="sr-item-desc">{!! $highlight($desc, $query) !!}</p>
                @endif
              </div>
              <span class="sr-item-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
@endsection

@push('scripts')
<script>
(function(){
  var tabs = document.querySelectorAll('#srTabs .sr-tab');
  var sections = document.querySelectorAll('.sr-section');
  if(!tabs.length) return;
  tabs.forEach(function(tab){
    tab.addEventListener('click', function(){
      var target = tab.getAttribute('data-target');
      tabs.forEach(function(t){ t.classList.remove('act'); });
      tab.classList.add('act');
      sections.forEach(function(s){
        var sec = s.getAttribute('data-section');
        if(target === 'all' || target === sec) s.style.display = '';
        else s.style.display = 'none';
      });
    });
  });
})();
</script>
@endpush
