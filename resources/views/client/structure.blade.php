@extends('client.layouts.app')

@section('content')
    <!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h" {!! \App\Models\PageHero::style('structure') !!}>
  <div class="container">
    <nav class="breadcrumb" aria-label="@lang('site.structure')">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('site.str_breadcrumb')</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        <p class="page-hero-eyebrow" data-aos="fade-up">@lang('site.str_eyebrow')</p>
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          @lang('site.str_title_1') <em>@lang('site.str_title_em')</em> @lang('site.str_title_2')
        </h1>
        <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">
          @lang('site.str_sub')
        </p>
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200" aria-label="@lang('site.str_metrics')">
        <div class="stat"><div class="snum"><span>3</span></div><div class="slbl">@lang('site.str_stat_tier')</div></div>
        <div class="stat"><div class="snum"><span>{{ $countProjects }}</span><span class="pl">+</span></div><div class="slbl">@lang('site.str_stat_projects')</div></div>
        <div class="stat"><div class="snum"><span>{{ $countSupport }}</span></div><div class="slbl">@lang('site.str_stat_support')</div></div>
        <div class="stat"><div class="snum"><span>2</span></div><div class="slbl">@lang('site.str_stat_council')</div></div>
      </aside>
    </div>
  </div>
</section>

<!-- ── ORG TREE ── -->
<section id="org-tree" aria-labelledby="ot-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('site.str_org_label')</p>
      <h2 class="s-title" id="ot-h" data-aos="fade-up" data-aos-delay="80">@lang('site.str_org_title')</h2>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="120" style="margin:1rem auto 0">@lang('site.str_org_desc')</p>
    </div>

    <div class="org-tree">

      <!-- TIER 1: Top organs -->
      <div class="org-tier org-tier-top" data-aos="fade-up">
        <div class="org-card">
          <span class="org-card-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 19a6 6 0 0 0-12 0"/><circle cx="8" cy="9" r="4"/><path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"/></svg></span>
          <span class="org-card-label">@lang('site.str_org_supervisory_lbl')</span>
          <h3 class="org-card-title">@lang('site.str_org_supervisory')</h3>
        </div>
        <div class="org-card lead">
          <span class="org-card-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
          <span class="org-card-label">@lang('site.adm_head_leader')</span>
          <h3 class="org-card-title">@lang('site.adm_stat_director')</h3>
        </div>
        <div class="org-card">
          <span class="org-card-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></span>
          <span class="org-card-label">@lang('site.str_org_scientific_lbl')</span>
          <h3 class="org-card-title">@lang('site.str_org_scientific')</h3>
        </div>
      </div>

      <div class="org-rail" aria-hidden="true"></div>

      <!-- TIER 2: Direct reports -->
      <div class="org-tier org-tier-mid" data-aos="fade-up" data-aos-delay="80">
        <div class="org-card dep-1">
          <span class="org-card-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span>
          <span class="org-card-label">@lang('site.str_dep1_lbl')</span>
          <h3 class="org-card-title">@lang('site.str_dep1_title')</h3>
        </div>
        <div class="org-card dep-2">
          <span class="org-card-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span>
          <span class="org-card-label">@lang('site.str_dep2_lbl')</span>
          <h3 class="org-card-title">@lang('site.str_dep_title')</h3>
        </div>
        <div class="org-card dep-3">
          <span class="org-card-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 19a6 6 0 0 0-12 0"/><circle cx="8" cy="9" r="4"/><path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"/></svg></span>
          <span class="org-card-label">@lang('site.str_dep3_lbl')</span>
          <h3 class="org-card-title">@lang('site.str_dep_title')</h3>
        </div>
        <div class="org-card dep-4">
          <span class="org-card-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 16l3-8 3 8c-2 1-4 1-6 0z"/><path d="M2 16l3-8 3 8c-2 1-4 1-6 0z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h18"/></svg></span>
          <span class="org-card-label">@lang('site.str_dep4_lbl')</span>
          <h3 class="org-card-title">@lang('site.str_dep4_title')</h3>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ── DEPARTMENTS BY GROUP ── -->
@if($deptGroups->count() > 0)
<section id="dept-groups" aria-labelledby="dg-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('site.str_proj_label')</p>
      <h2 class="s-title" id="dg-h" data-aos="fade-up" data-aos-delay="80">@lang('site.str_proj_title')</h2>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="120" style="margin:1rem auto 0">@lang('site.str_proj_desc')</p>
    </div>

    @foreach($deptGroups as $idx => $group)
      @php $parent = $group['parent']; $children = $group['children']; @endphp
      <div class="dept-group" data-aos="fade-up">
        <div class="dept-group-hdr">
          <span class="dept-group-num">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
          <div class="dept-group-info">
            <p class="dept-group-lbl">@lang('site.str_proj_subhead')</p>
            <h3 class="dept-group-title">{{ $parent ? $parent->getTitleAttribute() : '' }}</h3>
          </div>
        </div>
        <div class="dept-list">
          @foreach($children as $child)
            <div class="dept-item"><span class="dept-item-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/></svg></span><span>{{ $child->getTitleAttribute() }}</span></div>
          @endforeach
        </div>
      </div>
    @endforeach

  </div>
</section>
@endif

<!-- ── SUPPORT SERVICES ── -->
@if($supportItems->count() > 0)
<section id="support-services" aria-labelledby="ss-h">
  <div class="container">
    <div class="news-hdr" style="display:block;text-align:center">
      <p class="s-lbl" style="justify-content:center" data-aos="fade-up">@lang('site.str_supp_label')</p>
      <h2 class="s-title" id="ss-h" data-aos="fade-up" data-aos-delay="80">@lang('site.str_supp_title')</h2>
      <p class="s-desc" data-aos="fade-up" data-aos-delay="120" style="margin:1rem auto 0">@lang('site.str_supp_desc')</p>
    </div>

    @php
      $supportIcons = [
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 19a6 6 0 0 0-12 0"/><circle cx="8" cy="9" r="4"/><path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 16l3-8 3 8c-2 1-4 1-6 0z"/><path d="M2 16l3-8 3 8c-2 1-4 1-6 0z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h18"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/></svg>',
      ];
    @endphp

    <div class="support-grid">
      @foreach($supportItems as $idx => $item)
        <article class="support-card" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 60 }}">
          <span class="support-card-num">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
          <div class="support-card-ico">{!! $supportIcons[$idx % count($supportIcons)] !!}</div>
          <h3 class="support-card-title">{{ $item->getTitleAttribute() }}</h3>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif
@endsection
