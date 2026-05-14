@extends('client.layouts.app')

@section('metadata')
  <title>@lang('site.employees') | @lang('index.index')</title>
  <meta name="description" content="@lang('site.employees') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('site.employees')">
  <meta property="og:title" content="@lang('site.employees') | @lang('index.index')">
  <meta property="og:description" content="@lang('site.employees') | @lang('index.index_des')">
@endsection

@section('content')
<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.employees')</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.emp_eyebrow')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          @lang('site.emp_title')
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          @lang('site.emp_sub')
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ── EMPLOYEES (heads) ── -->
<section id="employees" aria-labelledby="emp-h">
  <div class="container">

    @if($heads->count() > 0)
    <div class="adm-grid">
      @foreach($heads as $idx => $leader)
      <article class="adm-card" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 80 }}">
        <div class="adm-card-photo">
          @if($leader->image)
            <img src="{{ asset('images/employees/' . $leader->image) }}" alt="{{ $leader->getNameAttribute() ?: $leader->getPositionAttribute() }}" loading="lazy">
          @else
            <span class="adm-card-photo-ph" aria-hidden="true">
              <span class="adm-card-photo-letter">{{ mb_substr($leader->getNameAttribute() ?: $leader->getPositionAttribute(), 0, 1) }}</span>
            </span>
          @endif
          @if($leader->is_vacant)
            <span class="adm-vacant-tag">@lang('site.emp_vacant')</span>
          @endif
        </div>
        <div class="adm-card-body">
          <p class="adm-card-pos">{{ $leader->getPositionAttribute() }}</p>
          @if($leader->getNameAttribute())
            <h3 class="adm-card-name">{{ $leader->getNameAttribute() }}</h3>
          @else
            <h3 class="adm-card-name adm-card-name-vacant">@lang('site.emp_vacant_position')</h3>
          @endif
          @if($leader->getProjectAttribute())
            <p class="adm-card-duties">
              <span class="emp-project-label">@lang('site.emp_project')</span>
              {{ $leader->getProjectAttribute() }}
            </p>
          @endif
          @if($leader->email)
          <ul class="adm-card-contact">
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <span class="emp-email-label">@lang('site.emp_email')</span>
              <a href="mailto:{{ $leader->email }}">{{ $leader->email }}</a>
            </li>
          </ul>
          @endif

          @if($leader->team->count() > 0)
            <button type="button" class="leader-bio-btn adm-bio-toggle"
                    aria-expanded="false"
                    aria-controls="team-{{ $leader->id }}">
              <span class="adm-bio-label-show">@lang('site.emp_team_show', ['count' => $leader->team->count()])</span>
              <span class="adm-bio-label-hide">@lang('site.emp_team_hide')</span>
              <svg class="adm-bio-chev" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="adm-card-bio" id="team-{{ $leader->id }}" hidden>
              <div class="emp-team">
                <p class="emp-team-title">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  @lang('site.emp_team_label')
                  <span class="emp-team-count">{{ $leader->team->count() }}</span>
                </p>
                <ul class="emp-team-list">
                  @foreach($leader->team as $member)
                    <li class="emp-team-item">
                      <div class="emp-team-photo">
                        @if($member->image)
                          <img src="{{ asset('images/employees/' . $member->image) }}" alt="{{ $member->getNameAttribute() ?: $member->getPositionAttribute() }}" loading="lazy">
                        @else
                          <span class="emp-team-ph" aria-hidden="true">
                            <span class="emp-team-letter">{{ mb_substr($member->getNameAttribute() ?: $member->getPositionAttribute(), 0, 1) }}</span>
                          </span>
                        @endif
                      </div>
                      <div class="emp-team-text">
                        @if($member->getNameAttribute())
                          <p class="emp-team-name">{{ $member->getNameAttribute() }}</p>
                        @else
                          <p class="emp-team-name emp-team-name-vacant">@lang('site.emp_vacant_position')</p>
                        @endif
                        <p class="emp-team-pos">{{ $member->getPositionAttribute() }}</p>
                        @if($member->email)
                          <a class="emp-team-mail" href="mailto:{{ $member->email }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span class="emp-email-label">@lang('site.emp_email')</span>
                            {{ $member->email }}
                          </a>
                        @endif
                      </div>
                      @if($member->is_vacant)
                        <span class="emp-team-vacant">@lang('site.emp_vacant')</span>
                      @endif
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif
        </div>
      </article>
      @endforeach
    </div>
    @else
      <p style="text-align:center;color:var(--t2);padding:3rem 0">@lang('site.emp_empty')</p>
    @endif

  </div>
</section>
@endsection

@push('scripts')
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
@endpush
