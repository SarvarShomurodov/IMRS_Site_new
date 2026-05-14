@extends('client.journal_site.layouts.app')

@section('title', __('journal.issues.page_title'))

@section('content')

<section class="jsite-list-sec">
  <div class="jsite-container">

    {{-- Page header --}}
    <header class="jsite-issues-head">
      <nav class="jsite-crumb" aria-label="Breadcrumb">
        <a href="{{ route('journals') }}">@lang('journal.show.breadcrumb_journal')</a>
        <span class="jsite-crumb-sep">/</span>
        <span aria-current="page">@lang('journal.issues.page_title')</span>
      </nav>
      <p class="jsite-issues-eyebrow">@lang('journal.issues.eyebrow')</p>
      <h1 class="jsite-issues-title">@lang('journal.issues.title')</h1>
      <p class="jsite-issues-sub">@lang('journal.issues.sub')</p>
    </header>

    @if($issues->isEmpty())
      <div class="jsite-issues-empty">
        <div class="jsite-issues-empty-ico" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <p class="jsite-issues-empty-msg">@lang('journal.issues.empty')</p>
      </div>
    @else
      <ul class="jsite-issues-grid" role="list">
        @foreach($issues as $issue)
          @php
            $coverUrl = !empty($issue->image) ? asset('images/journals/' . $issue->image) : null;
            $titleI   = $issue->getTitleAttribute();
            $timeI    = $issue->getTimeAttribute();
          @endphp
          <li class="jsite-issue-card" data-aos="fade-up">
            <a href="{{ route('journal.issue', $issue->id) }}" class="jsite-issue-cover" aria-label="{{ $titleI }}">
              @if($coverUrl)
                <img src="{{ $coverUrl }}" alt="{{ $titleI }}" loading="lazy">
              @else
                <div class="jsite-issue-cover-fb">
                  <span>IMRS</span>
                  <small>№{{ $issue->id }}</small>
                </div>
              @endif
              <span class="jsite-issue-num">№{{ $issue->id }}</span>
            </a>
            <div class="jsite-issue-body">
              <h3 class="jsite-issue-title">
                <a href="{{ route('journal.issue', $issue->id) }}">{{ $titleI }}</a>
              </h3>
              @if($timeI)
                <p class="jsite-issue-time">{{ $timeI }}</p>
              @endif
              <div class="jsite-issue-meta">
                @if(!empty($issue->issn))
                  <span class="jsite-issue-meta-item">
                    <span class="jsite-issue-meta-lbl">ISSN</span>
                    <span class="jsite-issue-meta-val">{{ $issue->issn }}</span>
                  </span>
                @endif
                <span class="jsite-issue-meta-item">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  {{ number_format((int) ($issue->views ?? 0)) }}
                </span>
              </div>
              <div class="jsite-issue-actions">
                <a href="{{ route('journal.issue', $issue->id) }}" class="jsite-issue-btn primary">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                  @lang('journal.issues.read')
                </a>
                <a href="{{ asset('files/journals/' . $issue->journal) }}" class="jsite-issue-btn ghost" target="_blank" rel="noopener" download>
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  @lang('journal.issues.download')
                </a>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    @endif

  </div>
</section>

@endsection
