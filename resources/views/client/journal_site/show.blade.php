@extends('client.journal_site.layouts.app')

@php
  $loc      = app()->getLocale();
  $title    = $article->pubTitle();
  $cover    = $article->pubCover() ? asset('storage/' . $article->pubCover()) : null;
  $author   = $article->author ? $article->author->fullName() : '—';
  $workplace = $article->author->workplace ?? null;
  $pubDate  = $article->publish_date ?: $article->updated_at;
  $dateD    = $pubDate ? $pubDate->locale($loc)->isoFormat('YYYY · D MMM') : '';
  $tagsArr  = is_array($article->tags) ? $article->tags : [];
  $fileUrl  = $article->file_path ? asset('storage/' . $article->file_path) : null;
  $description = $article->pubDescription();
@endphp

@section('title', $title . ' — IMRS Journal')

@section('content')

<section class="jsite-show-hero">
  <div class="jsite-container">
    <nav class="jsite-crumb" aria-label="Breadcrumb">
      <a href="{{ route('journals') }}">@lang('journal.show.breadcrumb_journal')</a>
      <span class="jsite-crumb-sep">/</span>
      @if($article->category)
        <a href="{{ route('journals', ['cat' => $article->category]) }}">{{ $article->category }}</a>
        <span class="jsite-crumb-sep">/</span>
      @endif
      <span aria-current="page">№{{ $article->id }}</span>
    </nav>

    @if($article->category)
      <p class="jsite-show-eyebrow">{{ $article->category }} · №{{ $article->id }}</p>
    @else
      <p class="jsite-show-eyebrow">IMRS Journal · №{{ $article->id }}</p>
    @endif

    <h1 class="jsite-show-title">{{ $title }}</h1>

    <div class="jsite-show-meta-top">
      <span class="jsite-show-author"><strong>{{ $author }}</strong>@if($workplace), <span>{{ $workplace }}</span>@endif</span>
      @if($dateD)
        <span class="jsite-show-dot">·</span>
        <span class="jsite-show-date">{{ $dateD }}</span>
      @endif
      <span class="jsite-show-dot">·</span>
      <span class="jsite-show-views">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        {{ number_format((int) $article->views) }}
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
              <small>№{{ $article->id }}</small>
            </div>
          @endif
        </div>

        <ul class="jsite-show-meta">
          @if($article->category)
            <li><span>@lang('journal.show.meta_category')</span><b>{{ $article->category }}</b></li>
          @endif
          <li><span>@lang('journal.show.meta_views')</span><b>{{ number_format((int) $article->views) }}</b></li>
          @if($pubDate)
            <li><span>@lang('journal.show.meta_pub_date')</span><b>{{ $pubDate->format('Y-m-d') }}</b></li>
          @endif
        </ul>

        @if($fileUrl)
          <div class="jsite-show-actions">
            <a class="jsite-btn jsite-btn-primary" href="{{ $fileUrl }}" target="_blank" rel="noopener">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span>@lang('journal.show.btn_download')</span>
            </a>
          </div>
        @endif

        @if(!empty($tagsArr))
          <div class="jsite-show-tags">
            <h4 class="jsite-show-tags-title">@lang('journal.show.tags_title')</h4>
            <ul>
              @foreach($tagsArr as $t)
                <li><a href="{{ route('journals', ['tag' => $t]) }}">#{{ $t }}</a></li>
              @endforeach
            </ul>
          </div>
        @endif
      </aside>

      <div class="jsite-show-main">

        @php
          $docExt = $article->file_path ? strtolower(pathinfo($article->file_path, PATHINFO_EXTENSION)) : null;
          $isOfficeDoc = $docExt && in_array($docExt, ['doc','docx','rtf','odt','xls','xlsx','ppt','pptx'], true);
          $viewerUrl = ($fileUrl && $isOfficeDoc)
            ? 'https://view.officeapps.live.com/op/embed.aspx?src=' . urlencode($fileUrl)
            : null;
        @endphp

        @if($viewerUrl)
          <div class="jsite-doc-viewer">
            <div class="jsite-doc-viewer-head">
              <span class="jsite-doc-viewer-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
              </span>
              <span class="jsite-doc-viewer-name">{{ $article->file_original_name ?: basename($article->file_path) }}</span>
              <a class="jsite-doc-viewer-open" href="{{ $fileUrl }}" target="_blank" rel="noopener" aria-label="Yangi oynada ochish">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              </a>
            </div>
            <iframe
              class="jsite-doc-viewer-frame"
              src="{{ $viewerUrl }}"
              title="{{ $title }}"
              frameborder="0"
              loading="lazy"
              allowfullscreen></iframe>
          </div>
        @elseif($description)
          <article class="jsite-show-content">
            {!! nl2br(e($description)) !!}
          </article>
        @else
          <article class="jsite-show-content">
            <p><em>@lang('journal.show.no_description')</em></p>
          </article>
        @endif

        @if(!empty($related) && $related->count())
          <section class="jsite-show-related">
            <h3 class="jsite-show-related-title">@lang('journal.show.related_title')</h3>
            <ul class="jsite-related-list">
              @foreach($related as $r)
                @php
                  $rTitle = $r->pubTitle();
                  $rCover = $r->pubCover() ? asset('storage/' . $r->pubCover()) : null;
                  $rDate  = $r->publish_date ?: $r->updated_at;
                @endphp
                <li class="jsite-related-item">
                  <a href="{{ route('journal', $r->id) }}" class="jsite-related-cover">
                    @if($rCover)
                      <img src="{{ $rCover }}" alt="{{ $rTitle }}" loading="lazy">
                    @else
                      <div class="jsite-article-cover-fb"><span>IMRS</span></div>
                    @endif
                  </a>
                  <div class="jsite-related-body">
                    @if($r->category)
                      <span class="jsite-related-cat">{{ $r->category }}</span>
                    @endif
                    <a href="{{ route('journal', $r->id) }}" class="jsite-related-title">{{ $rTitle }}</a>
                    @if($rDate)
                      <span class="jsite-related-date">{{ $rDate->format('Y-m-d') }}</span>
                    @endif
                  </div>
                </li>
              @endforeach
            </ul>
          </section>
        @endif

        @if($prev || $next)
          <nav class="jsite-pgnav" aria-label="Navigation">
            @if($prev)
              <a class="jsite-pgnav-item jsite-pgnav-prev" href="{{ route('journal', $prev->id) }}">
                <span class="jsite-pgnav-arrow">←</span>
                <span class="jsite-pgnav-text">
                  <span class="jsite-pgnav-lbl">@lang('journal.show.prev')</span>
                  <span class="jsite-pgnav-title">{{ $prev->pubTitle() }}</span>
                </span>
              </a>
            @else
              <span></span>
            @endif
            @if($next)
              <a class="jsite-pgnav-item jsite-pgnav-next" href="{{ route('journal', $next->id) }}">
                <span class="jsite-pgnav-text">
                  <span class="jsite-pgnav-lbl">@lang('journal.show.next')</span>
                  <span class="jsite-pgnav-title">{{ $next->pubTitle() }}</span>
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
