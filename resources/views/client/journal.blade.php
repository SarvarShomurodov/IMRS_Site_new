@extends('client.layouts.app')

@section('metadata')
  <title>{{ $item->getTitleAttribute() }} | @lang('index.index')</title>
  <meta name="description" content="{{ $item->getTitleAttribute() }} | @lang('index.index_des')">
  <meta name="keywords" content="{{ $item->getTitleAttribute() }}">
  <meta property="og:title" content="{{ $item->getTitleAttribute() }} | @lang('index.index')">
  <meta property="og:description" content="{{ $item->getTitleAttribute() }} | @lang('index.index_des')">
@endsection

@section('content')
<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h" {!! \App\Models\PageHero::style('journal') !!}>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <a href="{{ route('journals.archive') }}">@lang('index.journals')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">№{{ $item->id }}</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.journal') · №{{ $item->id }}</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          <em>{{ $item->getTitleAttribute() }}</em>
        </h1>
        @if($item->getTimeAttribute())
          <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">{{ $item->getTimeAttribute() }}</p>
        @endif
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200">
        <div class="stat"><div class="snum"><span>№{{ $item->id }}</span></div><div class="slbl">@lang('index.journals')</div></div>
        @if(!empty($item->issn))
          <div class="stat"><div class="snum" style="font-size:.95rem"><span>{{ $item->issn }}</span></div><div class="slbl">ISSN</div></div>
        @else
          <div class="stat"><div class="snum"><span>PDF</span></div><div class="slbl">@lang('index.download')</div></div>
        @endif
        <div class="stat"><div class="snum"><span>{{ $item->views ?? 0 }}</span></div><div class="slbl">@lang('site.views')</div></div>
        <div class="stat"><div class="snum"><span>{{ \Carbon\Carbon::parse($item->created_at)->year }}</span></div><div class="slbl">@lang('site.pgs_stat_latest')</div></div>
      </aside>
    </div>
  </div>
</section>

<!-- ── JOURNAL DETAIL ── -->
<section class="jrn-detail" aria-labelledby="jd-h">
  <div class="container">
    <div class="jrn-detail-wrap">
      <aside class="jrn-detail-aside" data-aos="fade-up">
        <div class="jrn-detail-cover">
          @if(!empty($item->image))
            <img src="{{ asset('images/journals/' . $item->image) }}" alt="{{ $item->getTitleAttribute() }}">
          @else
            <div class="jrn-detail-fallback"><span>IMRS</span><small>@lang('site.journal')</small></div>
          @endif
        </div>

        <div class="jrn-detail-actions">
          @if($item->getPdfAttribute())
            <a class="jrn-action-btn primary" href="{{ $item->getPdfAttribute() }}" target="_blank" rel="noopener">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              @lang('index.fullscreen')
            </a>
            <a class="jrn-action-btn gold" href="{{ $item->getPdfAttribute() }}" download>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              @lang('index.download')
            </a>
          @endif
          <div class="ya-share2" data-curtain data-shape="round" data-services="vkontakte,facebook,odnoklassniki,telegram,twitter"></div>
        </div>
      </aside>

      <div class="jrn-detail-main">
        <p class="jrn-detail-eyebrow" data-aos="fade-up">@lang('site.journal') · №{{ $item->id }}</p>
        <h2 class="jrn-detail-title" id="jd-h" data-aos="fade-up" data-aos-delay="60">{{ $item->getTitleAttribute() }}</h2>
        @if($item->getTimeAttribute())
          <p class="jrn-detail-period" data-aos="fade-up" data-aos-delay="120">{{ $item->getTimeAttribute() }}</p>
        @endif

        <div class="jrn-detail-stats" data-aos="fade-up" data-aos-delay="160">
          <div class="jrn-stat">
            <span class="jrn-stat-num">№<em>{{ $item->id }}</em></span>
            <span class="jrn-stat-lbl">@lang('index.journals')</span>
          </div>
          @if(!empty($item->issn))
            <div class="jrn-stat">
              <span class="jrn-stat-num" style="font-size:1.05rem">{{ $item->issn }}</span>
              <span class="jrn-stat-lbl">ISSN</span>
            </div>
          @endif
          <div class="jrn-stat">
            <span class="jrn-stat-num">{{ $item->views ?? 0 }}</span>
            <span class="jrn-stat-lbl">@lang('site.views')</span>
          </div>
          <div class="jrn-stat">
            <span class="jrn-stat-num">{{ \Carbon\Carbon::parse($item->created_at)->year }}</span>
            <span class="jrn-stat-lbl">@lang('site.pgs_stat_latest')</span>
          </div>
        </div>

        @if($item->getPdfAttribute())
          <div class="jrn-pdf-frame" data-aos="fade-up" data-aos-delay="80">
            <div class="jrn-pdf-head">
              <div class="jrn-pdf-ico">PDF</div>
              <div class="jrn-pdf-info">
                <b>{{ $item->getTitleAttribute() }}</b>
                <span>{{ $item->getTimeAttribute() ?: '—' }}</span>
              </div>
            </div>
            <iframe src="{{ $item->getPdfAttribute() }}" loading="lazy" title="{{ $item->getTitleAttribute() }}"></iframe>
          </div>
        @endif

        <div class="jrn-meta-list">
          @if($item->getEditorialStaffAttribute())
            <div class="jrn-meta-row" data-aos="fade-up">
              <div class="jrn-meta-label">@lang('index.editorial_staff')</div>
              <div class="jrn-meta-value">{!! $item->getEditorialStaffAttribute() !!}</div>
            </div>
          @endif
          @if($item->getEditorialBoardAttribute())
            <div class="jrn-meta-row" data-aos="fade-up">
              <div class="jrn-meta-label">@lang('index.editorial_board')</div>
              <div class="jrn-meta-value">{!! $item->getEditorialBoardAttribute() !!}</div>
            </div>
          @endif
          @if($item->getSubscriptionAttribute())
            <div class="jrn-meta-row" data-aos="fade-up">
              <div class="jrn-meta-label">@lang('index.subscription')</div>
              <div class="jrn-meta-value">{!! $item->getSubscriptionAttribute() !!}</div>
            </div>
          @endif
          @if($item->getSubmissionAttribute())
            <div class="jrn-meta-row" data-aos="fade-up">
              <div class="jrn-meta-label">@lang('index.submissions')</div>
              <div class="jrn-meta-value">{!! $item->getSubmissionAttribute() !!}</div>
            </div>
          @endif
          @if($item->getNewsAttribute())
            <div class="jrn-meta-row" data-aos="fade-up">
              <div class="jrn-meta-label">@lang('index.journal_news')</div>
              <div class="jrn-meta-value">{!! $item->getNewsAttribute() !!}</div>
            </div>
          @endif
          @if($item->getContactsAttribute())
            <div class="jrn-meta-row" data-aos="fade-up">
              <div class="jrn-meta-label">@lang('index.journal_contacts')</div>
              <div class="jrn-meta-value">{{ $item->getContactsAttribute() }}</div>
            </div>
          @endif
        </div>

        @if($item1 || $item2)
          <nav class="page-nav" aria-label="@lang('index.navigation')" style="margin-top:1.5rem">
            @if($item1)
              <a class="page-nav-item page-nav-prev" href="{{ route('journal.archive', $item1->id) }}">
                <span class="page-nav-arrow">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </span>
                <span class="nav-text">
                  <span class="nav-label">@lang('index.back')</span>
                  <span class="nav-title">{{ $item1->getTitleAttribute() }}</span>
                </span>
              </a>
            @endif
            @if($item2)
              <a class="page-nav-item page-nav-next" href="{{ route('journal.archive', $item2->id) }}">
                <span class="nav-text">
                  <span class="nav-label">@lang('index.forward')</span>
                  <span class="nav-title">{{ $item2->getTitleAttribute() }}</span>
                </span>
                <span class="page-nav-arrow">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </span>
              </a>
            @endif
          </nav>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="https://yastatic.net/share2/share.js"></script>
@endpush
