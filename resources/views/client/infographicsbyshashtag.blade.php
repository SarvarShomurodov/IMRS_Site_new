@extends('client.layouts.app')

@section('metadata')
  <title>#{{ $hashtag->title }} | @lang('index.infographics')</title>
  <meta name="description" content="#{{ $hashtag->title }} | @lang('index.infographics') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.infographics'), #{{ $hashtag->title }}">
  <meta property="og:title" content="#{{ $hashtag->title }} | @lang('index.infographics')">
  <meta property="og:description" content="#{{ $hashtag->title }} | @lang('index.infographics')">
@endsection

@section('content')
@php
  $count = is_countable($infographics) ? count($infographics) : 0;
@endphp

<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <a href="{{ route('infographics') }}">@lang('index.infographics')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">#{{ $hashtag->title }}</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('index.infographics')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          <em>#{{ $hashtag->title }}</em>
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          Tegga oid barcha infografika va vizual materiallar ro'yxati.
        </p>
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200">
        <div class="stat"><div class="snum"><span>{{ $count }}</span></div><div class="slbl">@lang('index.infographics')</div></div>
        <div class="stat"><div class="snum"><span>#</span></div><div class="slbl">{{ \Illuminate\Support\Str::limit($hashtag->title, 14) }}</div></div>
        <div class="stat"><div class="snum"><span>HD</span></div><div class="slbl">@lang('site.photogallery')</div></div>
        <div class="stat"><div class="snum"><span>—</span></div><div class="slbl">@lang('index.infographics')</div></div>
      </aside>
    </div>
  </div>
</section>

<!-- ── BY HASHTAG ── -->
<section id="infographics-list" aria-labelledby="igh-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">#{{ $hashtag->title }}</p>
      <h2 class="s-title" id="igh-h" data-aos="fade-up" data-aos-delay="80">@lang('index.infographics')</h2>
    </div>

    @if($count > 0)
      <div class="ig-grid">
        @foreach($infographics as $idx => $item)
          <a href="{{ route('infographics.item', $item->id) }}" class="ig-card" data-aos="fade-up" data-aos-delay="{{ ($idx % 8) * 50 }}">
            <div class="ig-img">
              @if(!empty($item->image))
                <img src="/images/galleries/{{ $item->image }}" alt="{{ $item->getTitleAttribute() }}" loading="lazy">
              @endif
              <span class="ig-zoom" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
              </span>
            </div>
            <div class="ig-body">
              <h3 class="ig-title">{{ $item->getTitleAttribute() }}</h3>
              <span class="ig-cta">@lang('site.read_more') <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
            </div>
          </a>
        @endforeach
      </div>
    @else
      <p style="text-align:center;color:var(--t2);padding:3rem 0">@lang('site.pgs_empty')</p>
    @endif
  </div>
</section>
@endsection
