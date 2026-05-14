@extends('client.layouts.app')

@section('title', 'IMRS — ' . __('site.hero_title_1') . ' ' . __('site.hero_title_2') . ' ' . __('site.hero_title_3'))

@section('content')
<!-- ── HERO ── -->
<section id="hero" aria-labelledby="hero-h">
  <!-- Video background: o'zingizning video faylingizni shu yerga qo'ying -->
  <div class="hero-video-bg" aria-hidden="true">
    <video
      id="hero-video"
      autoplay
      muted
      loop
      playsinline
      preload="auto"
    >
      <source src="{{asset('assets/video/Taqdimot_cnv.mp4')}}" type="video/mp4">
    </video>
  </div>
  <div class="hero-video-overlay" aria-hidden="true"></div>
  <canvas id="hero-canvas"></canvas>
  <div class="hero-mesh"></div>
  <div class="hero-grid"></div>
  <div class="container">
    <div class="hero-inner">
      <div>
        <div class="hero-badge" data-aos="fade-up">
          <div class="bp"></div>
          @lang('site.hero_badge')
        </div>
        <h1 class="hero-title" id="hero-h" data-aos="fade-up" data-aos-delay="80">
          @lang('site.hero_title_1')<br><em>@lang('site.hero_title_2')</em><br>@lang('site.hero_title_3')
        </h1>
        <p class="hero-desc" data-aos="fade-up" data-aos-delay="160">
          @lang('site.hero_desc')
        </p>
        <div class="hero-acts" data-aos="fade-up" data-aos-delay="220">
          <a href="#publications" class="btn-p"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> @lang('site.hero_cta_pubs')</a>
          <a href="#news" class="btn-g"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a4 4 0 0 1-4-4V6"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6z"/></svg> @lang('site.hero_cta_news')</a>
          <a href="https://imrs.uz/contacts" class="btn-g" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> @lang('site.hero_cta_contact')</a>
        </div>
        <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
          <div class="stat"><div class="snum"><span id="c1">0</span><span class="pl">+</span></div><div class="slbl">@lang('site.stat_experience')</div></div>
          <div class="stat"><div class="snum"><span id="c2">0</span><span class="pl">+</span></div><div class="slbl">@lang('site.stat_publications')</div></div>
          <div class="stat"><div class="snum"><span id="c3">0</span></div><div class="slbl">@lang('site.stat_monitoring')</div></div>
          <div class="stat"><div class="snum"><span id="c4">0</span><span class="pl">+</span></div><div class="slbl">@lang('site.stat_partners')</div></div>
        </div>
      </div>

      <!-- HERO SIDE: latest news featured card -->
      @php
        $latestNews = $news->first();
        $latestNewsCategory = $latestNews ? $latestNews->categories()->first() : null;
      @endphp
      @if($latestNews)
      <aside class="hero-side" data-aos="fade-left" data-aos-delay="200" aria-label="@lang('site.news')">
        <a href="{{ $latestNewsCategory ? route('news', [$latestNewsCategory->slug, $latestNews->slug]) : '#' }}" class="hero-feature hero-feature--news">
          <div class="hf-shine" aria-hidden="true"></div>
          <div class="hf-top">
            <span class="hf-label"><span class="hf-dot"></span> @lang('site.news')</span>
            @if($latestNewsCategory)
              <span class="hf-badge">{{ $latestNewsCategory->title }}</span>
            @endif
          </div>
          @if($latestNews->issetImage())
          <div class="hf-cover">
            <img src="{{ $latestNews->getImageAttribute() }}" alt="{{ $latestNews->getTitleAttribute() }}" loading="lazy">
          </div>
          @endif
          <div class="hf-meta">
            <h3 class="hf-title">{{ $latestNews->getTitleAttribute() }}</h3>
            <p class="hf-sub">{{ $latestNews->getCreatedData() }}</p>
          </div>
          <div class="hf-foot">
            <span class="hf-cta">@lang('site.read_more')
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
        </a>
      </aside>
      @endif

    </div>
  </div>
</section>

<!-- ── NEWS ── -->
@if(count($news) > 0)
@php
  $featuredNews = $news[0];
  $featuredCategory = $featuredNews->categories()->first();
  $listNews = $news->slice(1);
  $featDescRaw = $featuredNews->issetDescription()
    ? trim(preg_replace('/\s+/u', ' ', strip_tags((string)$featuredNews->getShortDescriptionAttribute())))
    : '';
  $featDescRaw = \Illuminate\Support\Str::limit($featDescRaw, 180);
@endphp
<section id="news" class="nx-section" aria-labelledby="news-h">
  <span class="nx-deco nx-deco-a" aria-hidden="true"></span>
  <span class="nx-deco nx-deco-b" aria-hidden="true"></span>

  <div class="container">
    <header class="nx-hdr">
      <div class="nx-hdr-l">
        <p class="s-lbl" data-aos="fade-up">
          <span class="nx-live" aria-hidden="true"><span class="nx-live-dot"></span> Live</span>
          @lang('site.news_section_label')
        </p>
        <h2 class="s-title nx-title" id="news-h" data-aos="fade-up" data-aos-delay="80">
          @lang('site.news') <em class="nx-title-accent">·</em>
        </h2>
        <p class="s-desc nx-desc" data-aos="fade-up" data-aos-delay="120">
          @lang('site.news_section_label') — IMRS faoliyati, tadqiqotlar va so'nggi yangiliklar.
        </p>
      </div>
      <a href="{{ route('archives', 'news') }}" class="link-all nx-all" data-aos="fade-up" data-aos-delay="100">
        @lang('site.all') <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </header>

    <div class="nx-grid">
      <!-- Featured -->
      <a href="{{ $featuredCategory ? route('news', [$featuredCategory->slug, $featuredNews->slug]) : '#' }}" class="nx-feat" data-aos="fade-up">
        <div class="nx-feat-img">
          @if($featuredNews->issetImage())
            <img src="{{ $featuredNews->getImageAttribute() }}" alt="{{ $featuredNews->getTitleAttribute() }}" loading="lazy">
          @endif
          <span class="nx-feat-num" aria-hidden="true">01</span>
          <span class="nx-feat-tag">
            <span class="nx-live-dot"></span> @lang('site.arc_featured_tag')
          </span>
        </div>
        <div class="nx-feat-body">
          <span class="nx-feat-cat">{{ $featuredCategory ? $featuredCategory->title : __('site.news_item') }}</span>
          <h3 class="nx-feat-title">{{ $featuredNews->getTitleAttribute() }}</h3>
          @if($featDescRaw)
            <p class="nx-feat-desc">{{ $featDescRaw }}</p>
          @endif
          <div class="nx-feat-foot">
            <div class="nx-feat-meta">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $featuredNews->getCreatedData() }}
              </span>
              @if(!empty($featuredNews->views))
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  {{ $featuredNews->views }}
                </span>
              @endif
            </div>
            <span class="nx-feat-cta">
              @lang('site.read_more')
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
        </div>
      </a>

      <!-- List -->
      <div class="nx-list" data-aos="fade-up" data-aos-delay="80">
        @foreach($listNews as $idx => $item)
          @php $itemCategory = $item->categories()->first(); @endphp
          <a href="{{ $itemCategory ? route('news', [$itemCategory->slug, $item->slug]) : '#' }}" class="nx-item">
            <span class="nx-item-num" aria-hidden="true">{{ str_pad($idx + 2, 2, '0', STR_PAD_LEFT) }}</span>
            <div class="nx-item-thumb">
              @if($item->issetImage())
                <img src="{{ $item->getImageAttribute() }}" alt="" loading="lazy">
              @else
                <span class="nx-item-thumb-ph" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </span>
              @endif
            </div>
            <div class="nx-item-body">
              <span class="nx-item-cat">{{ $itemCategory ? $itemCategory->title : __('site.news_item') }}</span>
              <h4 class="nx-item-title">{{ $item->getShortTitleAttribute() }}</h4>
              <span class="nx-item-meta">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $item->getCreatedData() }}@if(!empty($item->views)) <span class="nx-item-dot">·</span> {{ $item->views }} @lang('site.views')@endif
              </span>
            </div>
            <span class="nx-item-arrow" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

<!-- ── PUBLICATIONS ── -->
@if(count($publications) > 0)
<section id="publications" aria-labelledby="pub-h">
  <div class="container">
    <div class="pub-hdr">
      <div>
        <p class="s-lbl" data-aos="fade-up">@lang('site.pubs_section_label')</p>
        <h2 class="s-title" id="pub-h" data-aos="fade-up" data-aos-delay="80">{{ $article ? $article->title : __('site.pubs_section_title') }}</h2>
      </div>
      @if($article)
      <a href="{{ route('publications', $article->slug) }}" class="link-all" data-aos="fade-up" data-aos-delay="100">
        @lang('site.all') <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
      @endif
    </div>
    <div class="pub-list">
      @foreach($publications as $idx => $publication)
        @php $pubCategory = $publication->categories()->first(); @endphp
        <a href="{{ $pubCategory ? route('publicationItem', [$pubCategory->slug, $publication->slug]) : '#' }}" class="pub-item" data-aos="fade-up" @if($idx > 0) data-aos-delay="{{ $idx * 60 }}" @endif tabindex="0">
          <span class="pub-n">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
          <div class="pub-ico">
            @if($publication->image_uz || $publication->image_ru || $publication->image_en)
              <img src="{{ $publication->getImageAttribute() }}" alt="" loading="lazy">
            @endif
          </div>
          <div class="pub-body">
            <h3 class="ptitle">{{ $publication->getTitleAttribute() }}</h3>
            <div class="pmeta">
              <span>{{ $publication->getCreatedData() }}</span>
              @if($pubCategory)<span class="ptag">{{ $pubCategory->title }}</span>@endif
              @if(!empty($publication->views))
                <span class="news-views"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> {{ $publication->views }}</span>
              @endif
            </div>
          </div>
          <span class="parr"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ── JOURNALS ── -->
@if(count($journals) > 0)
@php
  $featuredJournal = $journals->first();
  $restJournals = $journals->slice(1);
@endphp
<section id="journals" class="jrn-section" aria-labelledby="jrn-h">
  <div class="jrn-bg-mesh" aria-hidden="true"></div>
  <div class="container">
    <div class="jrn-hdr">
      <div>
        <p class="s-lbl" data-aos="fade-up">@lang('site.journal_section_label')</p>
        <h2 class="s-title" id="jrn-h" data-aos="fade-up" data-aos-delay="80">@lang('site.journal_section_title')</h2>
        <p class="s-desc" data-aos="fade-up" data-aos-delay="120">@lang('site.journal_section_desc')</p>
      </div>
      <a href="{{ route('journals.archive') }}" class="link-all" data-aos="fade-up" data-aos-delay="100">@lang('site.all') <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
    </div>

    <!-- Featured journal hero card -->
    <a href="{{ route('journal.archive', $featuredJournal->id) }}" class="jrn-hero" data-aos="fade-up" data-aos-delay="140">
      <div class="jrn-hero-cover">
        @if($featuredJournal->image)
          <img src="{{ asset('images/journals/' . $featuredJournal->image) }}" alt="{{ $featuredJournal->title }}" loading="lazy" onerror="this.parentElement.classList.add('jrn-img-missing')">
        @else
          <div class="jrn-hero-fallback"><span>IMRS</span><small>Jurnal</small></div>
        @endif
        <span class="jrn-hero-glare" aria-hidden="true"></span>
      </div>
      <div class="jrn-hero-info">
        <span class="jrn-hero-tag"><span class="jrn-hero-dot"></span> @lang('site.latest_issue')</span>
        <span class="jrn-hero-num">№{{ $featuredJournal->id }}</span>
        <h3 class="jrn-hero-title">{{ $featuredJournal->title }}</h3>
        <p class="jrn-hero-period">{{ $featuredJournal->time }}</p>
        <div class="jrn-hero-meta">
          @if(!empty($featuredJournal->issn))
            <span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> ISSN {{ $featuredJournal->issn }}</span>
          @endif
          @if(!empty($featuredJournal->views))
            <span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> {{ $featuredJournal->views }}</span>
          @endif
        </div>
        <span class="jrn-hero-cta">
          @lang('site.read_journal')
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </span>
      </div>
    </a>

    @if(count($restJournals) > 0)
      <div class="jrn-grid">
        @foreach($restJournals as $idx => $journal)
          <a href="{{ route('journal.archive', $journal->id) }}" class="jrn-card" data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
            <div class="jrn-card-cover">
              @if($journal->image)
                <img src="{{ asset('images/journals/' . $journal->image) }}" alt="{{ $journal->title }}" loading="lazy" onerror="this.parentElement.classList.add('jrn-img-missing')">
              @else
                <div class="jrn-card-fallback">IMRS</div>
              @endif
              <span class="jrn-card-num">№{{ $journal->id }}</span>
              <span class="jrn-card-glare" aria-hidden="true"></span>
            </div>
            <div class="jrn-card-body">
              <p class="jrn-card-time">{{ $journal->time }}</p>
              <span class="jrn-card-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </div>
          </a>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endif

<!-- ── PARTNERS ── -->
@php
  $partnersTop = [
    ['logo'=>'undp.png',   'name'=>'UNDP',       'desc'=>"BMT Taraqqiyot dasturi",   'url'=>'https://www.undp.org/uzbekistan'],
    ['logo'=>'adb.jpg',    'name'=>'ADB',        'desc'=>'Osiyo Taraqqiyot Banki',   'url'=>'https://www.adb.org/countries/uzbekistan/main'],
    ['logo'=>'ebrd.jpg',   'name'=>'EBRD',       'desc'=>'Yevropa Taraqqiyot Banki', 'url'=>'https://www.ebrd.com/uzbekistan.html'],
    ['logo'=>'giz.jpg',    'name'=>'GIZ',        'desc'=>'Germaniya hamkorligi',     'url'=>'https://www.giz.de/en/worldwide/304.html'],
    ['logo'=>'isdb.jpg',   'name'=>'IsDB',       'desc'=>'Islom Taraqqiyot Banki',   'url'=>'https://www.isdb.org/'],
    ['logo'=>'twb.jpg',    'name'=>'World Bank', 'desc'=>'Jahon banki',              'url'=>'https://www.worldbank.org/en/country/uzbekistan'],
    ['logo'=>'jica.jpg',   'name'=>'JICA',       'desc'=>'Yaponiya agentligi',       'url'=>'https://www.jica.go.jp/uzbekistan/english/index.html'],
    ['logo'=>'koika.jpg',  'name'=>'KOICA',      'desc'=>'Koreya agentligi',         'url'=>'https://www.koica.go.kr/koica_en/index.do'],
  ];
  $partnersBot = [
    ['logo'=>'undesa.png', 'name'=>'UNDESA',  'desc'=>'BMT iqtisodiy bo\'limi',  'url'=>'https://www.un.org/en/desa'],
    ['logo'=>'jetro.png',  'name'=>'JETRO',   'desc'=>'Yaponiya tashqi savdosi', 'url'=>'https://www.jetro.go.jp/en/'],
    ['logo'=>'kotra.png',  'name'=>'KOTRA',   'desc'=>'Koreya savdo tashkiloti', 'url'=>'https://www.kotra.or.kr/foreign/main/KHEMUI010M.html'],
    ['logo'=>'mot.png',    'name'=>'MOT',     'desc'=>'Mehnat tashkiloti',       'url'=>'https://www.ilo.org/'],
    ['logo'=>'nagoya.jpg', 'name'=>'Nagoya',  'desc'=>'Nagoya universiteti',     'url'=>'https://en.nagoya-u.ac.jp/'],
    ['logo'=>'oon.png',    'name'=>'UN',      'desc'=>'Birlashgan Millatlar',    'url'=>'https://www.un.org/'],
    ['logo'=>'tika.png',   'name'=>'TIKA',    'desc'=>'Turkiya hamkorligi',      'url'=>'https://www.tika.gov.tr/en'],
    ['logo'=>'unicef.jpg', 'name'=>'UNICEF',  'desc'=>"BMT bolalar fondi",       'url'=>'https://www.unicef.org/uzbekistan/en'],
  ];
  $partnersTotal = count($partnersTop) + count($partnersBot);
@endphp
<section id="partners" class="partners-section" aria-label="Hamkorlar">
  <div class="partners-bg" aria-hidden="true">
    <div class="partners-orb partners-orb-a"></div>
    <div class="partners-orb partners-orb-b"></div>
  </div>
  <div class="container">
    <div class="partners-hdr" data-aos="fade-up">
      <p class="p-lbl">@lang('site.partners_label')</p>
      <h2 class="partners-title">@lang('site.partners_title')</h2>
      <div class="partners-stats">
        <div class="pstat"><span class="pstat-num">{{ $partnersTotal }}+</span><span class="pstat-lbl">@lang('site.partners_partner')</span></div>
        <div class="pstat-divider"></div>
        <div class="pstat"><span class="pstat-num">15+</span><span class="pstat-lbl">@lang('site.partners_country')</span></div>
        <div class="pstat-divider"></div>
        <div class="pstat"><span class="pstat-num">∞</span><span class="pstat-lbl">@lang('site.partners_together')</span></div>
      </div>
    </div>

    <div class="partners-rows" data-aos="fade-up" data-aos-delay="120">
      <div class="partners-marquee partners-row-top">
        <div class="partners-track">
          @for($pass = 0; $pass < 2; $pass++)
            @foreach($partnersTop as $p)
              <a class="p-card" href="{{ $p['url'] }}" target="_blank" rel="noopener noreferrer"
                 @if($pass) aria-hidden="true" tabindex="-1" @endif
                 title="{{ $p['name'] }} — {{ $p['desc'] }}">
                <div class="p-card-shine" aria-hidden="true"></div>
                <div class="p-card-logo"><img src="https://imrs.uz/images/noupload/partners/{{ $p['logo'] }}" alt="{{ $p['name'] }}" loading="lazy"></div>
                <div class="p-card-info">
                  <span class="p-card-name">{{ $p['name'] }}</span>
                  <span class="p-card-desc">{{ $p['desc'] }}</span>
                </div>
                <span class="p-card-ext" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                </span>
              </a>
            @endforeach
          @endfor
        </div>
      </div>
      <div class="partners-marquee partners-row-bot">
        <div class="partners-track">
          @for($pass = 0; $pass < 2; $pass++)
            @foreach($partnersBot as $p)
              <a class="p-card" href="{{ $p['url'] }}" target="_blank" rel="noopener noreferrer"
                 @if($pass) aria-hidden="true" tabindex="-1" @endif
                 title="{{ $p['name'] }} — {{ $p['desc'] }}">
                <div class="p-card-shine" aria-hidden="true"></div>
                <div class="p-card-logo"><img src="https://imrs.uz/images/noupload/partners/{{ $p['logo'] }}" alt="{{ $p['name'] }}" loading="lazy"></div>
                <div class="p-card-info">
                  <span class="p-card-name">{{ $p['name'] }}</span>
                  <span class="p-card-desc">{{ $p['desc'] }}</span>
                </div>
                <span class="p-card-ext" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                </span>
              </a>
            @endforeach
          @endfor
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
