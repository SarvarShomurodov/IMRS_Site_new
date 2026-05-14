@extends('client.layouts.app')

@section('metadata')
  <title>@lang('index.infographics') | @lang('index.index')</title>
  <meta name="description" content="@lang('index.infographics') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.infographics')">
  <meta property="og:title" content="@lang('index.infographics') | @lang('index.index')">
  <meta property="og:description" content="@lang('index.infographics') | @lang('index.index_des')">
@endsection

@section('content')
@php
  $count = is_countable($infographics) ? count($infographics) : 0;
@endphp

<!-- ── HERO ── -->
<section class="igx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('index.infographics')</span>
    </nav>

    <div class="igx-hero-row" data-aos="fade-up">
      <div class="igx-hero-l">
        <p class="igx-hero-eyebrow">
          <span class="igx-hero-eyebrow-mark" aria-hidden="true"></span>
          @lang('site.press')
        </p>
        <h1 class="igx-hero-title" id="ph-h">@lang('index.infographics')</h1>
        <p class="igx-hero-sub">@lang('site.rdx_intro_infographics')</p>
      </div>

      <div class="igx-hero-r" aria-hidden="true">
        <div class="igx-hero-cube igx-cube-1"></div>
        <div class="igx-hero-cube igx-cube-2"></div>
        <div class="igx-hero-cube igx-cube-3"></div>
        <div class="igx-hero-cube igx-cube-4"></div>
        <div class="igx-hero-cube igx-cube-5"></div>
        <div class="igx-hero-count">
          <span class="igx-hero-count-num">{{ $count }}</span>
          <span class="igx-hero-count-lbl">@lang('index.infographics')</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── BENTO GRID ── -->
<section class="igx-bento-sec" aria-labelledby="ig-h">
  <div class="container">
    <h2 class="sr-only" id="ig-h" style="position:absolute;left:-9999px">@lang('index.infographics')</h2>

    @if($count > 0)
      <div class="igx-bento" id="igxBento">
        @foreach($infographics as $idx => $item)
          @php
            // Pattern of 7: hero(2x2), 1x1, 1x1, wide(2x1), tall(1x2), 1x1, 1x1
            $mod = $idx % 7;
            $cls = '';
            if ($mod === 0)      { $cls = 'is-hero'; }
            elseif ($mod === 3)  { $cls = 'is-wide'; }
            elseif ($mod === 4)  { $cls = 'is-tall'; }
          @endphp
          <a href="{{ route('infographics.item', $item->id) }}" class="igx-cell {{ $cls }}" data-aos="fade-up" data-aos-delay="{{ ($idx % 6) * 60 }}">
            <div class="igx-cell-img">
              @if(!empty($item->image))
                <img src="/images/galleries/{{ $item->image }}" alt="{{ $item->getTitleAttribute() }}" loading="lazy">
              @else
                <div class="igx-cell-ph" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 12l4-4 4 6 5-9"/></svg>
                </div>
              @endif

              <span class="igx-cell-num" aria-hidden="true">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
              <span class="igx-cell-zoom" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </span>
            </div>

            <div class="igx-cell-body">
              <span class="igx-cell-tag">@lang('index.infographics')</span>
              <h3 class="igx-cell-title">{{ $item->getTitleAttribute() }}</h3>
              <span class="igx-cell-cta">
                @lang('site.read_more')
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
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
@endsection
