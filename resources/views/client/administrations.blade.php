@extends('client.layouts.app')

@section('content')
  <!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="@lang('site.leadership')">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.leadership')</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.adm_eyebrow')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          @lang('site.adm_title_1') <em>@lang('site.adm_title_em')</em>
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          @lang('site.adm_sub')
        </p>
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200" aria-label="@lang('site.adm_section_title')">
        <div class="stat">
          <div class="snum"><span>{{ $director ? 1 : 0 }}</span></div>
          <div class="slbl">@lang('site.adm_stat_director')</div>
        </div>
        <div class="stat">
          <div class="snum"><span>{{ $deputies->count() }}</span></div>
          <div class="slbl">@lang('site.adm_stat_deputy')</div>
        </div>
        <div class="stat">
          <div class="snum"><span>4</span></div>
          <div class="slbl">@lang('site.adm_stat_field')</div>
        </div>
        <div class="stat">
          <div class="snum"><span>15</span><span class="pl">+</span></div>
          <div class="slbl">@lang('site.adm_stat_years')</div>
        </div>
      </aside>
    </div>
  </div>
</section>

<!-- ── LEADERS ── -->
<section id="leaders" aria-labelledby="ld-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('site.adm_section_label')</p>
      <h2 class="s-title" id="ld-h" data-aos="fade-up" data-aos-delay="80">@lang('site.adm_section_title')</h2>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="120" style="margin:1rem auto 0">@lang('site.adm_section_desc')</p>
    </div>

    @php
      $phoneClean = function($p){ return preg_replace('/[^+\d]/', '', (string)$p); };
    @endphp

    @if($items->count() > 0)
    <div class="adm-grid">
      @foreach($items as $idx => $leader)
      <article class="adm-card" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 80 }}">
        <div class="adm-card-photo">
          @if($leader->image)
            <img src="{{ asset('images/administrations/' . $leader->image) }}" alt="{{ $leader->getNameAttribute() }} — {{ $leader->getTitleAttribute() }}" loading="lazy">
          @else
            <span class="adm-card-photo-ph" aria-hidden="true">
              <span class="adm-card-photo-letter">{{ mb_substr($leader->getNameAttribute(), 0, 1) }}</span>
            </span>
          @endif
        </div>
        <div class="adm-card-body">
          <p class="adm-card-pos">{{ $leader->getTitleAttribute() }}</p>
          <h3 class="adm-card-name">{{ $leader->getNameAttribute() }}</h3>
          @if($leader->getDutiesAttribute())
            <p class="adm-card-duties">{{ $leader->getDutiesAttribute() }}</p>
          @endif
          @if($leader->email || $leader->phone)
          <ul class="adm-card-contact">
            @if($leader->email)
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <a href="mailto:{{ $leader->email }}">{{ $leader->email }}</a>
              </li>
            @endif
            @if($leader->phone)
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5 19.79 19.79 0 0 1 1.61 5 2 2 0 0 1 3.6 2.68h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 18l.42-1.08z"/></svg>
                <a href="tel:{{ $phoneClean($leader->phone) }}">{{ $leader->phone }}</a>
              </li>
            @endif
          </ul>
          @endif
          @if($leader->getBiographyAttribute())
            <button type="button" class="leader-bio-btn adm-bio-toggle"
                    aria-expanded="false"
                    aria-controls="bio-{{ $leader->id }}">
              <span class="adm-bio-label-show">@lang('site.adm_biography')</span>
              <span class="adm-bio-label-hide">@lang('site.adm_biography_hide')</span>
              <svg class="adm-bio-chev" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="adm-card-bio" id="bio-{{ $leader->id }}" hidden>
              <div class="adm-card-bio-inner">{!! $leader->getBiographyAttribute() !!}</div>
            </div>
          @endif
        </div>
      </article>
      @endforeach
    </div>
    @endif

    <!-- CONTACT STRIP -->
    <div class="contact-strip" data-aos="fade-up">
      <div class="cs-item">
        <div class="cs-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <div class="cs-text">
          <span class="cs-lbl">@lang('site.adm_trust_phone')</span>
          <span class="cs-val"><a href="tel:+998712440180">+998 (71) 244-01-80</a></span>
        </div>
      </div>
      <div class="cs-item">
        <div class="cs-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5 19.79 19.79 0 0 1 1.61 5 2 2 0 0 1 3.6 2.68h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 18l.42-1.08z"/></svg></div>
        <div class="cs-text">
          <span class="cs-lbl">@lang('site.adm_main_phone')</span>
          <span class="cs-val"><a href="tel:+998712440117">+998 (71) 244-01-17</a></span>
        </div>
      </div>
      <div class="cs-item">
        <div class="cs-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
        <div class="cs-text">
          <span class="cs-lbl">@lang('site.adm_email')</span>
          <span class="cs-val"><a href="mailto:info@imrs.uz">info@imrs.uz</a></span>
        </div>
      </div>
      <div class="cs-item">
        <div class="cs-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div class="cs-text">
          <span class="cs-lbl">@lang('site.adm_address_label')</span>
          <span class="cs-val">@lang('site.adm_address')</span>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
(function(){
  document.addEventListener('click', function(e){
    var btn = e.target.closest('.adm-bio-toggle');
    if(!btn) return;
    e.preventDefault();
    var id = btn.getAttribute('aria-controls');
    var panel = id ? document.getElementById(id) : null;
    if(!panel) return;

    var isOpen = btn.getAttribute('aria-expanded') === 'true';
    if(isOpen){
      panel.style.maxHeight = panel.scrollHeight + 'px';
      requestAnimationFrame(function(){ panel.style.maxHeight = '0px'; });
      panel.addEventListener('transitionend', function onEnd(){
        panel.removeEventListener('transitionend', onEnd);
        if(btn.getAttribute('aria-expanded') === 'false'){
          panel.hidden = true;
          panel.style.maxHeight = '';
        }
      }, { once:true });
      btn.setAttribute('aria-expanded','false');
      btn.classList.remove('is-open');
    } else {
      panel.hidden = false;
      panel.style.maxHeight = '0px';
      requestAnimationFrame(function(){ panel.style.maxHeight = panel.scrollHeight + 'px'; });
      panel.addEventListener('transitionend', function onEnd(){
        panel.removeEventListener('transitionend', onEnd);
        if(btn.getAttribute('aria-expanded') === 'true'){
          panel.style.maxHeight = 'none';
        }
      }, { once:true });
      btn.setAttribute('aria-expanded','true');
      btn.classList.add('is-open');
    }
  });
})();
</script>

@endsection
