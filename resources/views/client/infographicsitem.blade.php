@extends('client.layouts.app')

@section('metadata')
  <title>{{ $infographics->getTitleAttribute() }} | @lang('index.index')</title>
  <meta name="description" content="{{ $infographics->getTitleAttribute() }} | @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.infographics'), {{ $infographics->getTitleAttribute() }}">
  <meta property="og:title" content="{{ $infographics->getTitleAttribute() }} | @lang('index.index')">
  <meta property="og:description" content="{{ $infographics->getTitleAttribute() }} | @lang('index.index_des')">
@endsection

@section('content')
<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h" {!! \App\Models\PageHero::style('infographicsitem') !!}>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <a href="{{ route('infographics') }}">@lang('index.infographics')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ \Illuminate\Support\Str::limit($infographics->getTitleAttribute(), 60) }}</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('index.infographics')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          <em>{{ $infographics->getTitleAttribute() }}</em>
        </h1>
      </div>
    </div>
  </div>
</section>

<!-- ── INFOGRAPHIC SINGLE ── -->
<section id="ig-single" aria-labelledby="igs-h">
  <div class="container">
    <div class="ig-single-wrap">
      <a class="ig-single-img" href="/images/galleries/{{ $infographics->image }}" target="_blank" rel="noopener" data-aos="fade-up">
        <img src="/images/galleries/{{ $infographics->image }}" alt="{{ $infographics->getTitleAttribute() }}">
      </a>

      <div class="ig-single-info" data-aos="fade-up" data-aos-delay="80">
        @if($infographics->getAntonationAttribute())
          <div class="ig-single-content">
            {!! $infographics->getAntonationAttribute() !!}
          </div>
        @endif

        @if($infographics->hashtags()->exists())
          <div class="ig-tags">
            @foreach($infographics->hashtags as $hashtag)
              <a class="ig-tag" href="{{ route('infographics.by.hashtag', $hashtag->id) }}">{{ $hashtag->title }}</a>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
