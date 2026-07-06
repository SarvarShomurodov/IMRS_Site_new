@extends('client.layouts.app')

@section('metadata')
  <title>{{ $item ? $item->getTitleAttribute() : '' }} | @lang('index.index')</title>
  <meta name="description" content="{{ $item ? $item->getMetaDescription() : '' }} | @lang('index.index_des')">
  <meta name="keywords" content="{{ $item ? $item->getMetaKeyword() : '' }}">
  <meta property="og:title" content="{{ $item ? $item->getTitleAttribute() : '' }} | @lang('index.index')">
  <meta property="og:description" content="{{ $item ? $item->getMetaDescription() : '' }} | @lang('index.index_des')">
@endsection

@section('content')
@if($item)
@php
  $children    = $item->child ?: collect();
  $childCount  = is_countable($children) ? count($children) : 0;
@endphp

<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h" {!! \App\Models\PageHero::style('publication_categories') !!}>
  <div class="container">
    <nav class="breadcrumb" aria-label="@lang('site.laws_breadcrumb_aria')">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <a href="{{ route('publications.all') }}">@lang('site.publications')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ $item->getTitleAttribute() }}</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.publications')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          <em>{{ $item->getTitleAttribute() }}</em>
        </h1>
        @if($item->getMetaDescription())
          <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">{{ $item->getMetaDescription() }}</p>
        @endif
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200">
        <div class="stat"><div class="snum"><span>{{ $childCount }}</span></div><div class="slbl">@lang('site.publications')</div></div>
        <div class="stat"><div class="snum"><span>—</span></div><div class="slbl">@lang('site.pgs_meta_category')</div></div>
        <div class="stat"><div class="snum"><span>HD</span></div><div class="slbl">@lang('site.publications')</div></div>
        <div class="stat"><div class="snum"><span>—</span></div><div class="slbl">{{ $item->getTitleAttribute() }}</div></div>
      </aside>
    </div>
  </div>
</section>

<!-- ── CATEGORIES GRID ── -->
<section id="pub-cats" aria-labelledby="pc-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">{{ $item->getTitleAttribute() }}</p>
      <h2 class="s-title" id="pc-h" data-aos="fade-up" data-aos-delay="80">@lang('site.publications')</h2>
    </div>

    @if($childCount > 0)
      <div class="pub-cat-grid">
        @foreach($children as $idx => $child)
          @php
            $img = $child->image ? '/images/publicationcategories/' . $child->image : null;
          @endphp
          <a class="pub-cat-card" href="{{ route('publications', $child->slug) }}" data-aos="fade-up" data-aos-delay="{{ ($idx % 4) * 60 }}">
            <div class="pub-cat-img">
              @if($img)
                <img src="{{ $img }}" alt="{{ $child->getTitleAttribute() }}" loading="lazy">
              @else
                <span class="pub-cat-img-ph">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </span>
              @endif
              <span class="pub-cat-badge">@lang('site.publications')</span>
            </div>
            <div class="pub-cat-body">
              <h3 class="pub-cat-title">{{ $child->getTitleAttribute() }}</h3>
              @if($child->getMetaDescription())
                <p class="pub-cat-desc">{{ \Illuminate\Support\Str::limit(strip_tags($child->getMetaDescription()), 120) }}</p>
              @endif
              <span class="pub-cat-cta">
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

@else

<!-- Toifa topilmadi -->
<section class="page-hero" aria-labelledby="ph-h" {!! \App\Models\PageHero::style('publication_categories') !!}>
  <div class="container">
    <nav class="breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
    </nav>
    <div class="page-hero-grid">
      <div>
        <h1 class="page-hero-title" id="ph-h">@lang('site.pgs_not_found')</h1>
        <p class="page-hero-sub">@lang('site.pgs_not_found_sub')</p>
      </div>
    </div>
  </div>
</section>

@endif
@endsection
