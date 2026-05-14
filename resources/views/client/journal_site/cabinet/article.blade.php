@extends('client.journal_site.cabinet._layout')

@section('title', $article->title_orig . ' — IMRS Journal')

@section('cabinet')

@php
  // Status'ga qarab User'ga ko'rsatiladigan sabab (rad etish yoki qayta ko'rib chiqish)
  $reasonVisible = in_array($article->status, ['technic_rejected', 'moderator_rejected', 'revision_requested'])
                    && $article->rejection_reason;
  $isRevision = $article->status === 'revision_requested';
@endphp

<header class="jsite-cab-head">
  <a href="{{ route('journal.cabinet.articles') }}" class="jsite-link-soft jsite-cab-back">
    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    <span>@lang('journal.cab.my_articles')</span>
  </a>

  <p class="jsite-cab-eyebrow">№{{ $article->id }} · {{ $article->created_at->format('Y-m-d') }}</p>
  <h1 class="jsite-cab-title">{{ $article->title_orig }}</h1>

  <div class="jsite-cab-head-status">
    @include('client.journal_site.components.status-badge', ['status' => $article->status])
  </div>
</header>

{{-- Rejection / revision note --}}
@if ($reasonVisible)
  <div class="jsite-alert {{ $isRevision ? 'jsite-alert-warn' : 'jsite-alert-err' }} jsite-alert-block">
    <strong>{{ $isRevision ? __('journal.cab.revision_reason') : __('journal.cab.rejection_reason') }}</strong>
    <p>{{ $article->rejection_reason }}</p>
  </div>
@endif

{{-- Resubmit notice (only for resubmittable statuses) --}}
@if ($article->isResubmittable())
  <div class="jsite-resubmit-notice">
    <h3>@lang('journal.cab.resubmit_title')</h3>
    <p>@lang('journal.cab.resubmit_sub')</p>
    <a href="{{ route('journal.cabinet.article.resubmit', $article->id) }}" class="jsite-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
      <span>@lang('journal.cab.resubmit_btn')</span>
    </a>
  </div>
@endif

{{-- Plagiarism (always visible if set) --}}
@if ($article->plagiarism_percent !== null)
  @include('client.journal_site.partials._plagiarism-card', ['percent' => $article->plagiarism_percent])
@endif

<div class="jsite-cab-detail-grid">

  {{-- Main info --}}
  <div class="jsite-cab-detail-main">

    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.cab.article_detail')</h2>

      <dl class="jsite-cab-meta">
        <div>
          <dt>@lang('journal.cab.orig_title')</dt>
          <dd>{{ $article->title_orig }}</dd>
        </div>
        <div>
          <dt>@lang('journal.cab.submitted_at')</dt>
          <dd>{{ $article->created_at->format('Y-m-d H:i') }}</dd>
        </div>
        <div>
          <dt>@lang('journal.cab.status')</dt>
          <dd>@include('client.journal_site.components.status-badge', ['status' => $article->status])</dd>
        </div>
        @if ($article->isPublished() && $article->category)
          <div>
            <dt>@lang('journal.admin.role')</dt>
            <dd>{{ $article->category }}</dd>
          </div>
        @endif
      </dl>
    </section>

    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.cab.file')</h2>
      <a href="{{ route('journal.cabinet.article.download', $article->id) }}" class="jsite-file-card">
        <span class="jsite-file-card-ico">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </span>
        <div class="jsite-file-card-info">
          <strong>{{ $article->file_original_name }}</strong>
          @if ($article->file_size)
            <span>{{ number_format($article->file_size / 1024 / 1024, 2) }} MB · @lang('journal.cab.download_file')</span>
          @endif
        </div>
        <span class="jsite-file-card-arrow">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        </span>
      </a>
    </section>

  </div>

  {{-- Timeline --}}
  <aside class="jsite-cab-detail-side">
    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.cab.history_title')</h2>
      <ol class="jsite-timeline">
        @foreach ($article->history as $h)
          <li class="jsite-timeline-item">
            <span class="jsite-timeline-dot" aria-hidden="true"></span>
            <div class="jsite-timeline-body">
              <strong>
                @include('client.journal_site.partials._history-action', ['action' => $h->action])
              </strong>
              @if ($h->to_status)
                <small>→ @lang('journal.status.'.$h->to_status)</small>
              @endif
              @if ($h->comment)
                <p>{{ $h->comment }}</p>
              @endif
              <time>{{ $h->created_at->format('Y-m-d H:i') }}</time>
            </div>
          </li>
        @endforeach
      </ol>
    </section>
  </aside>

</div>

@endsection
