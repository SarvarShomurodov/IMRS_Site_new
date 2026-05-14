@extends('client.journal_site.layouts.app')

@php
  $title    = $issue->getTitleAttribute();
  $timeI    = $issue->getTimeAttribute();
  $cover    = !empty($issue->image) ? asset('images/journals/' . $issue->image) : null;
  $pdfUrl   = !empty($issue->journal) ? asset('files/journals/' . $issue->journal) : null;
  $year     = $issue->created_at ? \Carbon\Carbon::parse($issue->created_at)->format('Y') : null;
@endphp

@section('title', $title . ' — IMRS Journal')

@section('content')

<section class="jsite-show-hero">
  <div class="jsite-container">
    <nav class="jsite-crumb" aria-label="Breadcrumb">
      <a href="{{ route('journals') }}">@lang('journal.show.breadcrumb_journal')</a>
      <span class="jsite-crumb-sep">/</span>
      <a href="{{ route('journal.issues') }}">@lang('journal.issues.page_title')</a>
      <span class="jsite-crumb-sep">/</span>
      <span aria-current="page">№{{ $issue->id }}</span>
    </nav>

    <p class="jsite-show-eyebrow">@lang('journal.issues.page_title') · №{{ $issue->id }}</p>
    <h1 class="jsite-show-title">{{ $title }}</h1>

    <div class="jsite-show-meta-top">
      @if($timeI)
        <span class="jsite-show-date">{{ $timeI }}</span>
        <span class="jsite-show-dot">·</span>
      @endif
      @if(!empty($issue->issn))
        <span class="jsite-show-author"><strong>ISSN</strong> {{ $issue->issn }}</span>
        <span class="jsite-show-dot">·</span>
      @endif
      <span class="jsite-show-views">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        {{ number_format((int) ($issue->views ?? 0)) }}
      </span>
    </div>
  </div>
</section>

<section class="jsite-show-body">
  <div class="jsite-container">
    <div class="jsite-show-grid">

      <aside class="jsite-show-aside">
        <div class="jsite-show-cover">
          @if($cover)
            <img src="{{ $cover }}" alt="{{ $title }}">
          @else
            <div class="jsite-show-cover-fb">
              <span>IMRS</span>
              <small>№{{ $issue->id }}</small>
            </div>
          @endif
        </div>

        <ul class="jsite-show-meta">
          <li><span>@lang('journal.issues.meta_number')</span><b>№{{ $issue->id }}</b></li>
          @if(!empty($issue->issn))
            <li><span>ISSN</span><b>{{ $issue->issn }}</b></li>
          @endif
          @if($timeI)
            <li><span>@lang('journal.issues.meta_period')</span><b>{{ $timeI }}</b></li>
          @endif
          @if($year)
            <li><span>@lang('journal.issues.meta_year')</span><b>{{ $year }}</b></li>
          @endif
          <li><span>@lang('journal.show.meta_views')</span><b>{{ number_format((int) ($issue->views ?? 0)) }}</b></li>
        </ul>

        @if($pdfUrl)
          <div class="jsite-show-actions">
            <a class="jsite-btn jsite-btn-primary" href="{{ $pdfUrl }}" target="_blank" rel="noopener" download>
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span>@lang('journal.issues.download')</span>
            </a>
            <a class="jsite-btn jsite-btn-ghost" href="{{ $pdfUrl }}" target="_blank" rel="noopener">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              <span>@lang('journal.issues.fullscreen')</span>
            </a>
          </div>
        @endif
      </aside>

      <div class="jsite-show-main">

        @if($pdfUrl)
          <div class="jsite-doc-viewer">
            <div class="jsite-doc-viewer-head">
              <span class="jsite-doc-viewer-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
              </span>
              <span class="jsite-doc-viewer-name">{{ $title }} · PDF</span>
              <a class="jsite-doc-viewer-open" href="{{ $pdfUrl }}" target="_blank" rel="noopener" aria-label="@lang('journal.issues.fullscreen')">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              </a>
            </div>
            <iframe
              class="jsite-doc-viewer-frame"
              src="{{ $pdfUrl }}#toolbar=1&navpanes=0&view=FitH"
              title="{{ $title }}"
              loading="lazy"
              allowfullscreen></iframe>
          </div>
        @else
          <article class="jsite-show-content">
            <p><em>@lang('journal.issues.no_pdf')</em></p>
          </article>
        @endif

        @if($prev || $next)
          <nav class="jsite-pgnav" aria-label="Navigation">
            @if($prev)
              <a class="jsite-pgnav-item jsite-pgnav-prev" href="{{ route('journal.issue', $prev->id) }}">
                <span class="jsite-pgnav-arrow">←</span>
                <span class="jsite-pgnav-text">
                  <span class="jsite-pgnav-lbl">@lang('journal.show.prev')</span>
                  <span class="jsite-pgnav-title">{{ $prev->getTitleAttribute() }}</span>
                </span>
              </a>
            @else
              <span></span>
            @endif
            @if($next)
              <a class="jsite-pgnav-item jsite-pgnav-next" href="{{ route('journal.issue', $next->id) }}">
                <span class="jsite-pgnav-text">
                  <span class="jsite-pgnav-lbl">@lang('journal.show.next')</span>
                  <span class="jsite-pgnav-title">{{ $next->getTitleAttribute() }}</span>
                </span>
                <span class="jsite-pgnav-arrow">→</span>
              </a>
            @endif
          </nav>
        @endif

      </div>
    </div>
  </div>
</section>

@endsection
