@extends('client.layouts.app')

@section('metadata')
  <title>@lang('site.history') | @lang('index.index')</title>
  <meta name="description" content="@lang('site.pg_h_sub')">
  <meta name="keywords" content="@lang('site.history'), IMRS">
  <meta property="og:title" content="@lang('site.history') | @lang('index.index')">
  <meta property="og:description" content="@lang('site.pg_h_sub')">
@endsection

@section('content')
<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h" {!! \App\Models\PageHero::style('history') !!}>
  <div class="container">
    <nav class="breadcrumb" aria-label="@lang('site.laws_breadcrumb_aria')">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span>@lang('site.about')</span>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.pg_h_breadcrumb')</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.pg_h_eyebrow')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          @lang('site.pg_h_title_1') <em>@lang('site.pg_h_title_em')</em> @lang('site.pg_h_title_2')
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          @lang('site.pg_h_sub')
        </p>
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200" aria-label="@lang('site.pg_h_metrics')">
        <div class="stat">
          <div class="snum"><span>57</span><span class="pl">+</span></div>
          <div class="slbl">@lang('site.pg_h_stat_years')</div>
        </div>
        <div class="stat">
          <div class="snum"><span>4</span></div>
          <div class="slbl">@lang('site.pg_h_stat_academic')</div>
        </div>
        <div class="stat">
          <div class="snum"><span>30</span><span class="pl">+</span></div>
          <div class="slbl">@lang('site.pg_h_stat_doctor')</div>
        </div>
        <div class="stat">
          <div class="snum"><span>100</span><span class="pl">+</span></div>
          <div class="slbl">@lang('site.pg_h_stat_candidate')</div>
        </div>
      </aside>
    </div>
  </div>
</section>

<!-- ── TIMELINE ── -->
<section id="timeline" aria-labelledby="tl-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('site.pg_h_tl_label')</p>
      <h2 class="s-title" id="tl-h" data-aos="fade-up" data-aos-delay="80">@lang('site.pg_h_tl_title')</h2>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="120" style="margin:1rem auto 0">@lang('site.pg_h_tl_desc')</p>
    </div>

    <div class="tl-wrap">
      <div class="tl-line" aria-hidden="true"></div>

      <div class="tl-item" data-aos="fade-up">
        <div class="tl-card">
          <div class="tl-card-year">1968</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl1_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl1_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl1_tag')</span>
        </div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div></div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div></div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div class="tl-card">
          <div class="tl-card-year">1986</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl2_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl2_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl2_tag')</span>
        </div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div class="tl-card">
          <div class="tl-card-year">1992</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl3_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl3_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl3_tag')</span>
        </div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div></div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div></div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div class="tl-card">
          <div class="tl-card-year">1994</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl4_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl4_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl4_tag')</span>
        </div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div class="tl-card">
          <div class="tl-card-year">1997</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl5_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl5_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl5_tag')</span>
        </div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div></div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div></div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div class="tl-card">
          <div class="tl-card-year">2000</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl6_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl6_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl6_tag')</span>
        </div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div class="tl-card">
          <div class="tl-card-year">2005</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl7_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl7_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl7_tag')</span>
        </div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div></div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div></div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div class="tl-card">
          <div class="tl-card-year">2008</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl8_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl8_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl8_tag')</span>
        </div>
      </div>

      <div class="tl-item" data-aos="fade-up">
        <div class="tl-card">
          <div class="tl-card-year">2023</div>
          <h3 class="tl-card-title">@lang('site.pg_h_tl9_title')</h3>
          <p class="tl-card-desc">@lang('site.pg_h_tl9_desc')</p>
          <span class="tl-card-tag">@lang('site.pg_h_tl9_tag')</span>
        </div>
        <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
        <div></div>
      </div>

    </div>
  </div>
</section>

<!-- ── MISSION / VALUES ── -->
<section id="mission" aria-labelledby="ms-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('site.pg_h_ms_label')</p>
      <h2 class="s-title" id="ms-h" data-aos="fade-up" data-aos-delay="80">@lang('site.pg_h_ms_title')</h2>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="120" style="margin:1rem auto 0">@lang('site.pg_h_ms_desc')</p>
    </div>

    <div class="mission-grid">
      <article class="mission-card" data-aos="fade-up">
        <div class="mission-ico">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
        </div>
        <h3>@lang('site.pg_h_ms1_title')</h3>
        <p>@lang('site.pg_h_ms1_desc')</p>
      </article>

      <article class="mission-card" data-aos="fade-up" data-aos-delay="80">
        <div class="mission-ico">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
        </div>
        <h3>@lang('site.pg_h_ms2_title')</h3>
        <p>@lang('site.pg_h_ms2_desc')</p>
      </article>

      <article class="mission-card" data-aos="fade-up" data-aos-delay="160">
        <div class="mission-ico">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <h3>@lang('site.pg_h_ms3_title')</h3>
        <p>@lang('site.pg_h_ms3_desc')</p>
      </article>
    </div>
  </div>
</section>
@endsection
