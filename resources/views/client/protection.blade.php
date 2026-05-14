@extends('client.layouts.app')

@section('metadata')
  <title>@lang('index.protection') | @lang('index.index')</title>
  <meta name="description" content="@lang('index.protection') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.protection')">
  <meta property="og:title" content="@lang('index.protection') | @lang('index.index')">
  <meta property="og:description" content="@lang('index.protection') | @lang('index.index_des')">
@endsection

@section('content')
@php
  $earliestYear = $scholars && count($scholars) ? \Carbon\Carbon::parse(collect($scholars)->min('created_at'))->year : null;
  $latestYear   = $scholars && count($scholars) ? \Carbon\Carbon::parse(collect($scholars)->max('created_at'))->year : null;
  $phdCount     = collect($scholars)->filter(fn($s) => stripos($s->getPhdDscAttribute() ?? '', 'phd') !== false)->count();
  $dscCount     = collect($scholars)->filter(fn($s) => stripos($s->getPhdDscAttribute() ?? '', 'dsc') !== false)->count();
@endphp

<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('index.protection')</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.science')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          <em>@lang('index.protection')</em>
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          IMRS huzuridagi PhD/DSc dissertatsiya himoyalari ro'yxati — mualliflar, mavzular, joylar va sanalar bo'yicha to'liq ma'lumot.
        </p>
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200" aria-label="@lang('index.protection')">
        <div class="stat"><div class="snum"><span>{{ count($scholars) }}</span></div><div class="slbl">@lang('index.protection')</div></div>
        <div class="stat"><div class="snum"><span>{{ $phdCount }}</span></div><div class="slbl">PhD</div></div>
        <div class="stat"><div class="snum"><span>{{ $dscCount }}</span></div><div class="slbl">DSc</div></div>
        <div class="stat"><div class="snum"><span>{{ $latestYear ?: '—' }}</span></div><div class="slbl">@lang('site.pgs_stat_latest')</div></div>
      </aside>
    </div>
  </div>
</section>

<!-- ── DEFENSES LIST ── -->
<section id="defenses" aria-labelledby="def-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('index.protection')</p>
      <h2 class="s-title" id="def-h" data-aos="fade-up" data-aos-delay="80">@lang('index.protection')</h2>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="120" style="margin:1rem auto 0">PhD va DSc darajalarini olish uchun himoya qilingan dissertatsiyalar.</p>
    </div>

    @if(count($scholars) > 0)
      <div class="def-list" id="defList">
        @foreach($scholars as $idx => $scholar)
          <article class="def-card" data-aos="fade-up" data-aos-delay="{{ ($idx % 6) * 60 }}">
            <div class="def-photo">
              @if(!empty($scholar->image))
                <img src="/images/scholars/{{ $scholar->image }}" alt="{{ $scholar->getNameAttribute() }}" loading="lazy">
              @endif
            </div>
            <div class="def-info">
              @if($scholar->getPhdDscAttribute())
                <span class="def-degree">{{ $scholar->getPhdDscAttribute() }}</span>
              @endif
              <h3 class="def-name">{{ $scholar->getNameAttribute() }}</h3>
              <p class="def-theme">{!! $scholar->getThemeAttribute() !!}</p>
              <div class="def-meta">
                @if($scholar->getCreatedData())
                  <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> {{ $scholar->getCreatedData() }}</span>
                @endif
                @if($scholar->getPlaceAttribute())
                  <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> {{ $scholar->getPlaceAttribute() }}</span>
                @endif
              </div>
            </div>
            <span class="def-action">@lang('site.read_more') <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
          </article>
        @endforeach
      </div>

      @if(!empty($scholarword) && !empty($scholarword->word))
        <div class="def-cta" data-aos="fade-up">
          <div class="def-cta-text">
            <h3>@lang('index.download_word')</h3>
            <p>Barcha dissertatsiyalar to'plami — Word formatida yuklab oling.</p>
          </div>
          <a href="/files/scholars/{{ $scholarword->word }}" target="_blank" rel="noopener">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            @lang('index.download_word')
          </a>
        </div>
      @endif
    @else
      <p style="text-align:center;color:var(--t2);padding:3rem 0">@lang('site.pgs_empty')</p>
    @endif
  </div>
</section>

@endsection
