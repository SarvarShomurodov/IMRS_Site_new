@extends('client.layouts.app')

@section('metadata')
  <title>@lang('site.publications') | @lang('index.index')</title>
  <meta name="description" content="@lang('site.publications') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('site.publications')">
  <meta property="og:title" content="@lang('site.publications') | @lang('index.index')">
  <meta property="og:description" content="@lang('site.publications') | @lang('index.index_des')">
@endsection

@section('content')
@php
  $featured = $items->first();
  $rest     = $items->getCollection()->slice(1);
  $latestYr = $items->count()
                ? \Carbon\Carbon::parse($items->getCollection()->max('created_at'))->year
                : null;
  $featDesc = '';
  if ($featured && $featured->issetDescription()) {
    $featDesc = html_entity_decode(strip_tags($featured->getDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $featDesc = trim(preg_replace('/\s+/u', ' ', $featDesc));
    $featDesc = \Illuminate\Support\Str::limit($featDesc, 240);
  }
  $featCat = $featured && $featured->categories->count() > 0 ? $featured->categories->first() : null;
@endphp

<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="@lang('site.laws_breadcrumb_aria')">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.publications')</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.publications')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          <em>@lang('site.publications')</em>
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          IMRS ekspertlarining barcha ilmiy nashrlari, tahliliy sharhlar va tadqiqot natijalari to'plami.
        </p>
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200">
        <div class="stat"><div class="snum"><span>{{ $items->total() }}</span></div><div class="slbl">@lang('site.publications')</div></div>
        <div class="stat"><div class="snum"><span>{{ $latestYr ?: '—' }}</span></div><div class="slbl">@lang('site.pgs_stat_latest')</div></div>
        <div class="stat"><div class="snum"><span>{{ $items->getCollection()->filter(fn($p) => $p->issetPdf())->count() }}</span></div><div class="slbl">PDF</div></div>
        <div class="stat"><div class="snum"><span>—</span></div><div class="slbl">@lang('site.publications')</div></div>
      </aside>
    </div>
  </div>
</section>

<!-- ── LIST ── -->
<section id="publications-list" aria-labelledby="pl-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('site.publications')</p>
      <h2 class="s-title" id="pl-h" data-aos="fade-up" data-aos-delay="80">@lang('site.publications')</h2>
    </div>

    @if($featured && $featCat)
      <article class="conf-featured" data-aos="fade-up">
        <div class="conf-feat-img">
          @if($featured->issetImage())
            <img src="{{ $featured->getImageAttribute() }}" alt="{{ $featured->getTitleAttribute() }}" loading="lazy">
          @endif
          <span class="conf-feat-status live">@lang('site.arc_featured_tag')</span>
        </div>
        <div class="conf-feat-body">
          <p class="conf-feat-eyebrow">{{ $featCat->getTitleAttribute() }}</p>
          <h3 class="conf-feat-title">{{ $featured->getTitleAttribute() }}</h3>
          @if($featDesc)
            <p class="conf-feat-desc">{{ $featDesc }}</p>
          @endif
          <div class="conf-feat-meta">
            <div class="dm-item">
              <div class="dm-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
              <div class="dm-text"><span class="dm-label">@lang('site.pgs_meta_date')</span><span class="dm-value">{{ $featured->getShortCreatedData() }}</span></div>
            </div>
            <div class="dm-item">
              <div class="dm-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
              <div class="dm-text"><span class="dm-label">@lang('site.pgs_meta_category')</span><span class="dm-value">{{ $featCat->getTitleAttribute() }}</span></div>
            </div>
            @if(!empty($featured->views))
              <div class="dm-item">
                <div class="dm-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                <div class="dm-text"><span class="dm-label">@lang('site.views')</span><span class="dm-value">{{ $featured->views }}</span></div>
              </div>
            @endif
            @if($featured->issetPdf() || $featured->issetVideo())
              <div class="dm-item">
                <div class="dm-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4z"/><line x1="13" y1="5" x2="13" y2="19"/></svg></div>
                <div class="dm-text"><span class="dm-label">@lang('site.attached_files')</span><span class="dm-value">{{ trim(($featured->issetPdf() ? 'PDF' : '') . (($featured->issetPdf() && $featured->issetVideo()) ? ' · ' : '') . ($featured->issetVideo() ? __('site.videogallery') : '')) }}</span></div>
              </div>
            @endif
          </div>
          <div class="conf-feat-cta">
            <a class="btn-p" href="{{ route('publicationItem', [$featCat->slug, $featured->slug]) }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg> @lang('site.read_more')</a>
            @if($featured->issetPdf())
              <a class="btn-g" href="{{ $featured->getPdfAttribute() }}" target="_blank" rel="noopener"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg> PDF</a>
            @endif
          </div>
        </div>
      </article>
    @endif

    @if($rest->count() > 0)
      <h3 class="s-title" data-aos="fade-up" style="font-size:clamp(1.4rem,2.5vw,1.85rem);margin-top:4rem;margin-bottom:.5rem">@lang('site.pgs_archive_title')</h3>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="60" style="margin-bottom:1.5rem">@lang('site.pgs_archive_desc')</p>

      <div class="conf-list">
        @foreach($rest as $pub)
          @php
            $cat = $pub->categories->count() > 0 ? $pub->categories->first() : null;
            if(!$cat) continue;
            $dt  = \Carbon\Carbon::parse($pub->created_at);
            $dt->locale(app()->getLocale());
          @endphp
          <a class="conf-row" href="{{ route('publicationItem', [$cat->slug, $pub->slug]) }}" data-aos="fade-up" style="text-decoration:none;color:inherit;cursor:pointer">
            <div class="conf-date">
              <div class="conf-date-day">{{ $dt->format('d') }}</div>
              <div class="conf-date-mon">{{ $dt->translatedFormat('M') }}</div>
              <div class="conf-date-year">{{ $dt->format('Y') }}</div>
            </div>
            <div class="conf-info">
              <span class="conf-cat">{{ $cat->getTitleAttribute() }}</span>
              <h3 class="conf-title">{{ $pub->getTitleAttribute() }}</h3>
              <div class="conf-meta-row">
                @if(!empty($pub->views))
                  <span class="conf-loc"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> {{ $pub->views }} @lang('site.views')</span>
                @endif
                @if($pub->issetPdf())
                  <span class="conf-loc"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg> PDF</span>
                @endif
              </div>
            </div>
            <span class="doc-action">@lang('site.read_more') <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
          </a>
        @endforeach
      </div>
    @endif

    {{-- Pagination --}}
    @if($items->hasPages())
      @php
        $curPage  = $items->currentPage();
        $lastPage = $items->lastPage();
      @endphp
      <nav class="pub-pagination" aria-label="@lang('index.navigation')" data-aos="fade-up">
        <a class="pub-page-nav {{ $curPage == 1 ? 'is-disabled' : '' }}" href="{{ $curPage > 1 ? $items->url($curPage - 1) : '#' }}" @if($curPage == 1) aria-disabled="true" @endif>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          <span>@lang('index.back')</span>
        </a>
        <ul class="pub-page-numbers">
          @for($p = 1; $p <= $lastPage; $p++)
            @if($p == $curPage)
              <li><span class="pub-page is-current" aria-current="page">{{ $p }}</span></li>
            @elseif($p == 1 || $p == $lastPage || abs($p - $curPage) <= 2)
              <li><a class="pub-page" href="{{ $items->url($p) }}">{{ $p }}</a></li>
            @elseif(abs($p - $curPage) == 3)
              <li><span class="pub-page-dots">…</span></li>
            @endif
          @endfor
        </ul>
        <a class="pub-page-nav {{ $curPage == $lastPage ? 'is-disabled' : '' }}" href="{{ $curPage < $lastPage ? $items->url($curPage + 1) : '#' }}" @if($curPage == $lastPage) aria-disabled="true" @endif>
          <span>@lang('index.next')</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </nav>
    @endif

    @if($items->isEmpty())
      <p style="text-align:center;color:var(--t2);padding:3rem 0">@lang('site.pgs_empty')</p>
    @endif

  </div>
</section>
@endsection
