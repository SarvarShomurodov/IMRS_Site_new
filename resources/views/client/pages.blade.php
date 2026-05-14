@extends('client.layouts.app')

@section('metadata')
  <title>{{ $item ? $item->getTitleAttribute() : '' }} | @lang('index.index')</title>
  <meta name="description" content="{{ $item ? $item->getMetaDescription() : '' }}">
  <meta name="keywords" content="{{ $item ? $item->getMetaKeyword() : '' }}">
@endsection

@section('content')
@php
  $category = $item;
  $pages    = $category ? $category->pages : collect();
  $latestYr = $pages->count()
                ? \Carbon\Carbon::parse($pages->max('created_at'))->year
                : null;

  $slug = $category ? $category->slug : null;
  // Slug bo'yicha skelet tanlanadi
  $isVacancy  = in_array($slug, ['vacancies', 'vakansiya', 'vakansii', 'jobs']);
  $isWebinar  = in_array($slug, ['webinar', 'webinars', 'vebinar', 'vebinars']);
@endphp

@if(!$category)
  <section class="pgx-hero" aria-labelledby="ph-h">
    <div class="container">
      <div class="pgx-hero-row">
        <div class="pgx-hero-l">
          <h1 class="pgx-hero-title" id="ph-h">@lang('site.pgs_not_found')</h1>
          <p class="pgx-hero-sub">@lang('site.pgs_not_found_sub')</p>
        </div>
      </div>
    </div>
  </section>

@elseif($isVacancy)
{{-- ═══════════════════════════════════════════════════════
     VACANCIES — JOB BOARD SKELETON
═══════════════════════════════════════════════════════ --}}

<!-- ── HERO ── -->
<section class="vcx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ $category->getTitleAttribute() }}</span>
    </nav>

    <div class="vcx-hero-row" data-aos="fade-up">
      <div class="vcx-hero-l">
        <p class="vcx-hero-eyebrow">
          <span class="vcx-hero-eyebrow-mark" aria-hidden="true"></span>
          @lang('site.pgs_eyebrow') · @lang('site.rdx_v_career')
        </p>
        <h1 class="vcx-hero-title" id="ph-h">{{ $category->getTitleAttribute() }}</h1>
        <p class="vcx-hero-sub">@lang('site.rdx_v_intro')</p>

        <div class="vcx-hero-meta">
          <span class="vcx-hero-meta-i">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <b>{{ $pages->count() }}</b> @lang('site.rdx_v_open_pos')
          </span>
          <span class="vcx-hero-meta-i">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            @lang('site.rdx_v_hybrid')
          </span>
          <span class="vcx-hero-meta-i">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            @lang('site.rdx_v_full_time')
          </span>
        </div>
      </div>

      <div class="vcx-hero-r" aria-hidden="true">
        <div class="vcx-hero-card">
          <span class="vcx-hero-card-num">{{ $pages->count() }}</span>
          <span class="vcx-hero-card-lbl">@lang('site.rdx_v_open_2l_a')<br>@lang('site.rdx_v_open_2l_b')</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── JOB BOARD ── -->
<section class="vcx-board-sec" aria-labelledby="vb-h">
  <div class="container">
    <header class="vcx-board-head" data-aos="fade-up">
      <h2 class="vcx-board-title" id="vb-h">@lang('site.rdx_v_jobs_list')</h2>
      <div class="vcx-board-search">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="search" id="vcxSearch" placeholder="@lang('site.rdx_v_search_ph')" aria-label="@lang('site.rdx_v_search_aria')">
      </div>
    </header>

    @if($pages->count() > 0)
      <div class="vcx-jobs" id="vcxJobs">
        @foreach($pages as $idx => $page)
          @php
            $dt = \Carbon\Carbon::parse($page->created_at);
            $dt->locale(app()->getLocale());
            $shortDesc = '';
            if ($page->issetDescription()) {
              $clean = html_entity_decode(strip_tags($page->getDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
              $clean = trim(preg_replace('/\s+/u', ' ', $clean));
              $shortDesc = \Illuminate\Support\Str::limit($clean, 180);
            }
            $isNew = $dt->diffInDays(now()) <= 14;
          @endphp
          <article class="vcx-job" data-aos="fade-up">
            <a href="{{ route('page', $page->slug) }}" class="vcx-job-link">
              <div class="vcx-job-l">
                <div class="vcx-job-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
              </div>

              <div class="vcx-job-c">
                <div class="vcx-job-meta-top">
                  @if($isNew)
                    <span class="vcx-tag vcx-tag-new">@lang('site.rdx_v_new')</span>
                  @endif
                  <span class="vcx-tag vcx-tag-cat">{{ $category->getTitleAttribute() }}</span>
                  <span class="vcx-job-date">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $dt->translatedFormat('j F Y') }}
                  </span>
                </div>

                <h3 class="vcx-job-title">{{ $page->getTitleAttribute() }}</h3>

                @if($shortDesc)
                  <p class="vcx-job-desc">{{ $shortDesc }}</p>
                @endif

                <div class="vcx-job-tags">
                  <span class="vcx-tag-info">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    @lang('site.rdx_v_city')
                  </span>
                  <span class="vcx-tag-info">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    @lang('site.rdx_v_full_time_short')
                  </span>
                  @if(!empty($page->views))
                    <span class="vcx-tag-info">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      {{ $page->views }} @lang('site.rdx_v_views_short')
                    </span>
                  @endif
                </div>
              </div>

              <div class="vcx-job-r">
                <span class="vcx-job-cta">
                  <span>@lang('site.rdx_v_apply')</span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
              </div>
            </a>
          </article>
        @endforeach
      </div>

      <p id="vcxEmptyMsg" class="vcx-empty" style="display:none">@lang('site.rdx_v_empty')</p>
    @else
      <p class="vcx-empty">@lang('site.pgs_empty')</p>
    @endif
  </div>
</section>

@elseif($isWebinar)
{{-- ═══════════════════════════════════════════════════════
     WEBINAR — EVENT TIMELINE SKELETON
═══════════════════════════════════════════════════════ --}}

<!-- ── HERO ── -->
<section class="wbx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ $category->getTitleAttribute() }}</span>
    </nav>

    <div class="wbx-hero-row" data-aos="fade-up">
      <div class="wbx-hero-l">
        <p class="wbx-hero-eyebrow">
          <span class="wbx-online-dot" aria-hidden="true"></span>
          @lang('site.rdx_w_online_events')
        </p>
        <h1 class="wbx-hero-title" id="ph-h">{{ $category->getTitleAttribute() }}</h1>
        <p class="wbx-hero-sub">@lang('site.rdx_w_intro')</p>
        <div class="wbx-hero-stats">
          <div class="wbx-hero-stat">
            <b>{{ $pages->count() }}</b>
            <span>@lang('site.rdx_w_event')</span>
          </div>
          <div class="wbx-hero-stat">
            <b>{{ $latestYr ?: '—' }}</b>
            <span>@lang('site.rdx_w_recent_lbl')</span>
          </div>
        </div>
      </div>

      <div class="wbx-hero-r" aria-hidden="true">
        <div class="wbx-screen">
          <div class="wbx-screen-bar">
            <span class="wbx-screen-dot"></span>
            <span class="wbx-screen-dot"></span>
            <span class="wbx-screen-dot"></span>
          </div>
          <div class="wbx-screen-body">
            <div class="wbx-screen-blob"></div>
            <div class="wbx-screen-blob wbx-blob-2"></div>
            <span class="wbx-screen-rec">REC ●</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── EVENT TIMELINE ── -->
<section class="wbx-timeline-sec" aria-labelledby="wb-h">
  <div class="container">
    <header class="wbx-timeline-head" data-aos="fade-up">
      <span class="wbx-timeline-line" aria-hidden="true"></span>
      <h2 class="wbx-timeline-title" id="wb-h">@lang('site.rdx_w_timeline')</h2>
    </header>

    @if($pages->count() > 0)
      <ol class="wbx-events" id="wbxEvents">
        @foreach($pages as $idx => $page)
          @php
            $dt = \Carbon\Carbon::parse($page->created_at);
            $dt->locale(app()->getLocale());
            $shortDesc = '';
            if ($page->issetDescription()) {
              $clean = html_entity_decode(strip_tags($page->getDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
              $clean = trim(preg_replace('/\s+/u', ' ', $clean));
              $shortDesc = \Illuminate\Support\Str::limit($clean, 200);
            }
            $hasVideo = method_exists($page, 'issetVideo') && $page->issetVideo();
          @endphp
          <li class="wbx-event {{ $idx % 2 === 0 ? 'is-left' : 'is-right' }}" data-aos="fade-up">
            <div class="wbx-event-peg" aria-hidden="true">
              <span class="wbx-event-peg-inner"></span>
            </div>

            <a class="wbx-event-card" href="{{ route('page', $page->slug) }}">
              <div class="wbx-event-date">
                <span class="wbx-event-day">{{ $dt->format('d') }}</span>
                <span class="wbx-event-mon">{{ $dt->translatedFormat('M') }}</span>
                <span class="wbx-event-year">{{ $dt->format('Y') }}</span>
              </div>

              <div class="wbx-event-body">
                <div class="wbx-event-meta">
                  <span class="wbx-event-tag">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    @lang('site.rdx_w_online_webinar')
                  </span>
                  @if($hasVideo)
                    <span class="wbx-event-tag wbx-event-tag-video">@lang('site.rdx_w_video_tag')</span>
                  @endif
                </div>

                <h3 class="wbx-event-title">{{ $page->getTitleAttribute() }}</h3>

                @if($shortDesc)
                  <p class="wbx-event-desc">{{ $shortDesc }}</p>
                @endif

                <div class="wbx-event-foot">
                  <span class="wbx-event-time">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $dt->translatedFormat('H:i') }}
                  </span>
                  <span class="wbx-event-cta">
                    {{ $hasVideo ? __('site.rdx_w_watch') : __('site.rdx_w_details') }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </span>
                </div>
              </div>
            </a>
          </li>
        @endforeach
      </ol>
    @else
      <p class="wbx-empty">@lang('site.pgs_empty')</p>
    @endif
  </div>
</section>

@else
{{-- ═══════════════════════════════════════════════════════
     DEFAULT — ZIGZAG STORIES SKELETON
═══════════════════════════════════════════════════════ --}}

<!-- ── HERO ── -->
<section class="pgx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">{{ $category->getTitleAttribute() }}</span>
    </nav>

    <div class="pgx-hero-row" data-aos="fade-up">
      <div class="pgx-hero-l">
        <p class="pgx-hero-eyebrow">@lang('site.pgs_eyebrow')</p>
        <h1 class="pgx-hero-title" id="ph-h">{{ $category->getTitleAttribute() }}</h1>
        @if($category->getMetaDescription())
          <p class="pgx-hero-sub">{{ $category->getMetaDescription() }}</p>
        @else
          <p class="pgx-hero-sub">@lang('site.pgs_default_sub')</p>
        @endif
      </div>

      <div class="pgx-hero-r" aria-hidden="true">
        <span class="pgx-hero-deco-1"></span>
        <span class="pgx-hero-deco-2"></span>
        <span class="pgx-hero-deco-3"></span>
        <span class="pgx-hero-num">{{ str_pad($pages->count(), 2, '0', STR_PAD_LEFT) }}</span>
      </div>
    </div>
  </div>
</section>

@if($pages->count() > 0)
<!-- ── ZIGZAG STORIES ── -->
<section class="pgx-stories-sec" aria-labelledby="pl-h">
  <div class="container">
    <h2 class="sr-only" id="pl-h" style="position:absolute;left:-9999px">{{ $category->getTitleAttribute() }}</h2>

    <div class="pgx-stories">
      @foreach($pages as $idx => $page)
        @php
          $dt = \Carbon\Carbon::parse($page->created_at);
          $dt->locale(app()->getLocale());
          $shortDesc = '';
          if ($page->issetDescription()) {
            $clean = html_entity_decode(strip_tags($page->getDescriptionAttribute()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $clean = trim(preg_replace('/\s+/u', ' ', $clean));
            $shortDesc = \Illuminate\Support\Str::limit($clean, 220);
          }
        @endphp
        <article class="pgx-story {{ $idx % 2 === 0 ? 'is-l' : 'is-r' }}" data-aos="fade-up">
          <a class="pgx-story-link" href="{{ route('page', $page->slug) }}">
            <div class="pgx-story-img">
              @if($page->issetImage())
                <img src="{{ $page->getImageAttribute() }}" alt="{{ $page->getTitleAttribute() }}" loading="lazy">
              @else
                <div class="pgx-story-img-ph" aria-hidden="true">
                  <span class="pgx-story-img-ph-letters">{{ mb_substr($category->getTitleAttribute(), 0, 1) }}</span>
                </div>
              @endif
              <span class="pgx-story-num">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="pgx-story-body">
              <div class="pgx-story-meta">
                <span class="pgx-story-cat">{{ $category->getTitleAttribute() }}</span>
                <span class="pgx-story-dot" aria-hidden="true"></span>
                <span class="pgx-story-date">{{ $dt->translatedFormat('j F Y') }}</span>
              </div>
              <h3 class="pgx-story-title">{{ $page->getTitleAttribute() }}</h3>
              @if($shortDesc)
                <p class="pgx-story-desc">{{ $shortDesc }}</p>
              @endif
              <div class="pgx-story-foot">
                @if(!empty($page->views))
                  <span class="pgx-story-views">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    {{ $page->views }}
                  </span>
                @endif
                @if($page->issetPdf())
                  <span class="pgx-story-pdf">PDF</span>
                @endif
                <span class="pgx-story-cta">
                  @lang('site.read_more')
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
              </div>
            </div>
          </a>
        </article>
      @endforeach
    </div>
  </div>
</section>
@else
<section class="pgx-stories-sec">
  <div class="container">
    <p class="pgx-empty">@lang('site.pgs_empty')</p>
  </div>
</section>
@endif

@endif
@endsection

@push('scripts')
<script>
(function(){
  // Vacancies search
  var vSearch = document.getElementById('vcxSearch');
  if(vSearch){
    var jobs = document.querySelectorAll('#vcxJobs .vcx-job');
    var emptyMsg = document.getElementById('vcxEmptyMsg');
    vSearch.addEventListener('input', function(){
      var q = this.value.toLowerCase().trim();
      var visible = 0;
      jobs.forEach(function(j){
        var t = j.textContent.toLowerCase();
        var show = !q || t.indexOf(q) !== -1;
        j.style.display = show ? '' : 'none';
        if(show) visible++;
      });
      if(emptyMsg) emptyMsg.style.display = visible === 0 ? '' : 'none';
    });
  }
})();
</script>
@endpush
