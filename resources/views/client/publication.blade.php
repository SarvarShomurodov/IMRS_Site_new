@extends('client.layouts.app')

@section('metadata')
  <title>{{ $item ? $item->getTitleAttribute() : '' }} | @lang('index.index')</title>
  <meta name="description" content="{{ $item ? $item->getMetaDescription() : '' }}">
  <meta name="keywords" content="{{ $item ? $item->getMetaKeyword() : '' }}">
  <meta property="og:title" content="{{ $item ? $item->getTitleAttribute() : '' }} | @lang('index.index')">
  <meta property="og:description" content="{{ $item ? $item->getMetaDescription() : '' }}">
  @if($item && $item->issetImage())
    <meta property="og:image" content="{{ $item->getImageAttribute() }}">
  @endif
@endsection

@section('content')
@if($item)
@php
  $dt = \Carbon\Carbon::parse($item->created_at);
  $dt->locale(app()->getLocale());

  // Reading time estimate (200 wpm)
  $rawText  = strip_tags((string) $item->getDescriptionAttribute());
  $rawText  = trim(preg_replace('/\s+/u', ' ', html_entity_decode($rawText, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
  $wordCount = $rawText ? str_word_count($rawText, 0, 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯʻOʻgʻIʻOʻGʻ') : 0;
  $readingTime = max(1, (int) ceil($wordCount / 200));

  $fileCount = ($item->issetPdf() ? 1 : 0)
             + ($item->issetVideo() ? 1 : 0)
             + (isset($item->files) ? $item->files->count() : 0);

  $coverUrl = $item->issetImage() ? $item->getImageAttribute() : null;
  $shareUrl = url()->current();
  $shareTxt = $item->getTitleAttribute();

  $citationYear = $dt->format('Y');
@endphp

{{-- Reading progress bar --}}
<div class="pubx-progress" id="pubxProgress" aria-hidden="true"><span></span></div>

<article class="pubx-doc" id="pubxDoc">
  {{-- ═══ HERO — magazine cover style ═══ --}}
  <header class="pubx-hero" @if($coverUrl) style="--cover:url('{{ $coverUrl }}')" @endif>
    <div class="pubx-hero-bg" aria-hidden="true">
      <div class="pubx-hero-img"></div>
      <div class="pubx-hero-vignette"></div>
      <span class="pubx-deco pubx-deco-1"></span>
      <span class="pubx-deco pubx-deco-2"></span>
      <span class="pubx-deco pubx-deco-3"></span>
      <canvas class="pubx-hero-particles" id="pubxParticles"></canvas>
    </div>

    <div class="container">
      <nav class="pubx-bc" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('publications.all') }}">@lang('site.publications')</a>
        @if($archive)
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
          <a href="{{ route('publications', $archive->slug) }}">{{ $archive->getTitleAttribute() }}</a>
        @endif
      </nav>

      <div class="pubx-hero-inner">
        <div class="pubx-hero-meta-row" data-aos="fade-up">
          @if($archive)
            <span class="pubx-chip pubx-chip-cat">
              <span class="pubx-chip-dot" aria-hidden="true"></span>
              {{ $archive->getTitleAttribute() }}
            </span>
          @endif
          <span class="pubx-chip">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            {{ $item->getCreatedData() }}
          </span>
          <span class="pubx-chip">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            {{ $readingTime }} @lang('site.pub_min')
          </span>
          @if(!empty($item->views))
            <span class="pubx-chip">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              {{ $item->views }}
            </span>
          @endif
        </div>

        <h5 class="pubx-hero-title" id="pubxTitle" data-aos="fade-up" data-aos-delay="100">
          {{ $item->getTitleAttribute() }}
        </h5>

        @if($item->getMetaDescription())
          <p class="pubx-hero-lede" data-aos="fade-up" data-aos-delay="180">{{ $item->getMetaDescription() }}</p>
        @endif

        <div class="pubx-byline" data-aos="fade-up" data-aos-delay="240">
          <div class="pubx-byline-avatar" aria-hidden="true">
            <span>IMRS</span>
          </div>
          <div class="pubx-byline-info">
            <span class="pubx-byline-name">@lang('site.pub_author')</span>
            <span class="pubx-byline-meta">{{ $dt->translatedFormat('j F Y') }}</span>
          </div>

          @if($fileCount > 0 || $item->issetPdf())
            <a class="pubx-byline-cta" href="#pubxFiles">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              {{ $fileCount }} {{ $fileCount === 1 ? __('site.attached_files') : __('site.attached_files') }}
            </a>
          @endif
        </div>
      </div>
    </div>

    {{-- Bottom curve / scroll indicator --}}
    <div class="pubx-hero-scroll" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
  </header>

  {{-- ═══ BODY: 3-col layout (share | article | meta) ═══ --}}
  <div class="pubx-stage">
    <div class="container">
      <div class="pubx-grid">

        {{-- ── Sticky share dock (left) ── --}}
        <aside class="pubx-dock" aria-label="Share">
          <div class="pubx-dock-inner">
            <span class="pubx-dock-lbl">@lang('site.pub_share')</span>

            <a class="pubx-dock-btn" href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTxt) }}" target="_blank" rel="noopener" aria-label="Telegram">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </a>
            <a class="pubx-dock-btn" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" aria-label="Facebook">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <a class="pubx-dock-btn" href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTxt) }}" target="_blank" rel="noopener" aria-label="X / Twitter">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2H21l-6.519 7.45L22 22h-6.85l-4.97-6.49L4.5 22H2l7.06-8.07L2 2h6.93l4.5 5.95L18.244 2zm-2.41 18h1.79L7.27 4h-1.9l10.464 16z"/></svg>
            </a>
            <a class="pubx-dock-btn" href="https://vk.com/share.php?url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTxt) }}" target="_blank" rel="noopener" aria-label="VK">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M15.07 2H8.93C3.33 2 2 3.33 2 8.93v6.14C2 20.67 3.33 22 8.93 22h6.14C20.67 22 22 20.67 22 15.07V8.93C22 3.33 20.65 2 15.07 2zm3.07 14.27h-1.46c-.55 0-.72-.45-1.71-1.43-.86-.84-1.24-.94-1.45-.94-.3 0-.39.08-.39.5v1.31c0 .36-.12.57-1.06.57-1.55 0-3.27-.94-4.49-2.7-1.83-2.55-2.33-4.46-2.33-4.86 0-.21.08-.4.5-.4h1.46c.38 0 .52.17.66.57.71 2.05 1.91 3.84 2.4 3.84.18 0 .27-.08.27-.55v-2.13c-.06-.98-.58-1.07-.58-1.42 0-.16.13-.33.34-.33h2.3c.32 0 .43.17.43.55v2.88c0 .32.14.43.23.43.18 0 .33-.11.66-.45.99-1.11 1.7-2.83 1.7-2.83.09-.21.26-.4.64-.4h1.46c.44 0 .54.22.44.54-.18.85-1.96 3.36-1.96 3.36-.15.25-.21.36 0 .64.15.21.66.65 1 1.04.62.7 1.09 1.29 1.22 1.7.13.41-.08.62-.5.62z"/></svg>
            </a>
            <a class="pubx-dock-btn" href="mailto:?subject={{ urlencode($shareTxt) }}&body={{ urlencode($shareUrl) }}" aria-label="Email">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </a>

            <span class="pubx-dock-divider"></span>

            <button class="pubx-dock-btn" id="pubxCopyLink" aria-label="Copy link" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            </button>
            @if($item->issetPdf())
              <a class="pubx-dock-btn pubx-dock-btn-accent" href="{{ $item->getPdfAttribute() }}" target="_blank" rel="noopener" aria-label="Download PDF">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              </a>
            @endif
          </div>
        </aside>

        {{-- ── Article body ── --}}
        <div class="pubx-body">
          @if($coverUrl)
            <figure class="pubx-cover" data-aos="fade-up">
              <div class="pubx-cover-frame">
                <img src="{{ $coverUrl }}" alt="{{ $item->getTitleAttribute() }}" loading="lazy">
              </div>
              @if($archive)
                <figcaption>{{ $archive->getTitleAttribute() }} · {{ $item->getCreatedData() }}</figcaption>
              @endif
            </figure>
          @endif

          @if($item->issetDescription())
            @php
              $description = $item->getDescriptionAttribute();
              $description = preg_replace('#((?:src|href)\s*=\s*["\'])((?:https?:)?//[^"\']+)/public/#i', '$1$2/', $description);
              $description = preg_replace('#((?:src|href)\s*=\s*["\'])/?public/#i', '$1/', $description);
              $description = preg_replace('#<img(?![^>]*\sloading=)#i', '<img loading="lazy"', $description);
            @endphp
            <div class="pubx-content page-article-content" id="pubxContent">
              {!! $description !!}
            </div>
          @endif

          @if($item->issetPdf())
            <section class="pubx-pdf" id="pubxFiles" data-aos="fade-up">
              <header class="pubx-pdf-head">
                <div class="pubx-pdf-ico">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <div class="pubx-pdf-info">
                  <span class="pubx-pdf-label">@lang('site.pub_doc_pdf')</span>
                  <h3 class="pubx-pdf-name">{{ $item->getTitleAttribute() }}</h3>
                </div>
                <a class="pubx-pdf-btn" href="{{ $item->getPdfAttribute() }}" target="_blank" rel="noopener">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  @lang('index.download')
                </a>
              </header>
              <iframe src="{{ $item->getPdfAttribute() }}" class="pubx-pdf-frame" loading="lazy" title="{{ $item->getTitleAttribute() }}"></iframe>
            </section>
          @endif

          @if(isset($item->files) && $item->files->count() > 0)
            <section class="pubx-files" data-aos="fade-up">
              <h3 class="pubx-files-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                @lang('site.attached_files')
              </h3>
              <div class="pubx-files-list">
                @foreach($item->files as $idx => $file)
                  @php
                    $ext = strtolower(pathinfo($file->file, PATHINFO_EXTENSION));
                    $extClass = in_array($ext, ['pdf']) ? 'pdf'
                              : (in_array($ext, ['doc','docx']) ? 'doc'
                              : (in_array($ext, ['xls','xlsx']) ? 'xls'
                              : (in_array($ext, ['ppt','pptx']) ? 'ppt'
                              : (in_array($ext, ['zip','rar','7z']) ? 'zip' : 'file'))));
                  @endphp
                  <a class="pubx-file pubx-file--{{ $extClass }}" href="/files/files/{{ $file->file }}" target="_blank" rel="noopener">
                    <span class="pubx-file-ico">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </span>
                    <span class="pubx-file-info">
                      <span class="pubx-file-label">{{ strtoupper($ext) ?: 'FILE' }}</span>
                      <span class="pubx-file-name">@lang('index.download') #{{ $idx + 1 }}</span>
                    </span>
                    <span class="pubx-file-arrow">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </span>
                  </a>
                @endforeach
              </div>
            </section>
          @endif

          @if($item->issetVideo())
            <section class="pubx-video" data-aos="fade-up">
              <div class="pubx-video-frame">
                <iframe src="{{ $item->getVideo() }}?feature=oembed&amp;rel=0&amp;modestbranding=1" allowfullscreen title="{{ $item->getTitleAttribute() }}"></iframe>
              </div>
            </section>
          @endif

          {{-- ── Topic chip + Cite this --}}
          <section class="pubx-bottom" data-aos="fade-up">
            @if($archive)
              <div class="pubx-tags">
                <span class="pubx-tags-lbl">@lang('site.pub_topic')</span>
                <a class="pubx-chip pubx-chip-topic" href="{{ route('publications', $archive->slug) }}">
                  {{ $archive->getTitleAttribute() }}
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
              </div>
            @endif

            <aside class="pubx-cite" id="pubxCite">
              <header class="pubx-cite-head">
                <span class="pubx-cite-eyebrow">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                  @lang('site.pub_cite')
                </span>
                <button class="pubx-cite-copy" id="pubxCiteCopy" type="button">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                  <span>@lang('site.pub_copy')</span>
                </button>
              </header>
              <p class="pubx-cite-text" id="pubxCiteText">@lang('site.pub_institute_full'). ({{ $citationYear }}). <em>{{ $item->getTitleAttribute() }}</em>. {{ $shareUrl }}</p>
            </aside>
          </section>
        </div>

        {{-- ── Sticky meta sidebar (right) ── --}}
        <aside class="pubx-meta" aria-label="Publication info">
          <div class="pubx-meta-card">
            <div class="pubx-meta-cover" @if($coverUrl) style="--c:url('{{ $coverUrl }}')" @endif></div>
            <div class="pubx-meta-list">
              @if($archive)
                <div class="pubx-meta-row">
                  <span class="pubx-meta-lbl">@lang('site.pub_category')</span>
                  <span class="pubx-meta-val">{{ $archive->getTitleAttribute() }}</span>
                </div>
              @endif
              <div class="pubx-meta-row">
                <span class="pubx-meta-lbl">@lang('site.pub_published')</span>
                <span class="pubx-meta-val">{{ $dt->translatedFormat('j F Y') }}</span>
              </div>
              <div class="pubx-meta-row">
                <span class="pubx-meta-lbl">@lang('site.pub_reading_time')</span>
                <span class="pubx-meta-val">~{{ $readingTime }} @lang('site.pub_min')</span>
              </div>
              @if(!empty($item->views))
                <div class="pubx-meta-row">
                  <span class="pubx-meta-lbl">@lang('site.views')</span>
                  <span class="pubx-meta-val">{{ $item->views }}</span>
                </div>
              @endif
              @if($fileCount > 0)
                <div class="pubx-meta-row">
                  <span class="pubx-meta-lbl">@lang('site.attached_files')</span>
                  <span class="pubx-meta-val">{{ $fileCount }}</span>
                </div>
              @endif
              @if($wordCount > 0)
                <div class="pubx-meta-row">
                  <span class="pubx-meta-lbl">@lang('site.pub_words')</span>
                  <span class="pubx-meta-val">{{ number_format($wordCount, 0, '.', ' ') }}</span>
                </div>
              @endif
            </div>

            @if($item->issetPdf())
              <a class="pubx-meta-cta" href="{{ $item->getPdfAttribute() }}" target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                @lang('index.download')
              </a>
            @endif
          </div>
        </aside>
      </div>
    </div>
  </div>

  {{-- ═══ Prev / Next nav ═══ --}}
  @if($item1 || $item2)
    <nav class="pubx-pagenav" aria-label="@lang('index.navigation')">
      <div class="container">
        <div class="pubx-pagenav-grid">
          @if($item1)
            <a class="pubx-pagenav-item pubx-pagenav-prev" href="{{ route('publicationItem', [$archive->slug, $item1->slug]) }}" rel="prev">
              <span class="pubx-pagenav-arrow" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
              </span>
              <span class="pubx-pagenav-text">
                <span class="pubx-pagenav-lbl">@lang('index.back')</span>
                <span class="pubx-pagenav-title">{{ $item1->getTitleAttribute() }}</span>
              </span>
            </a>
          @else
            <span></span>
          @endif

          @if($item2)
            <a class="pubx-pagenav-item pubx-pagenav-next" href="{{ route('publicationItem', [$archive->slug, $item2->slug]) }}" rel="next">
              <span class="pubx-pagenav-text">
                <span class="pubx-pagenav-lbl">@lang('index.forward')</span>
                <span class="pubx-pagenav-title">{{ $item2->getTitleAttribute() }}</span>
              </span>
              <span class="pubx-pagenav-arrow" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </a>
          @endif
        </div>
      </div>
    </nav>
  @endif
</article>

@else

<!-- Sahifa topilmadi -->
<section class="page-hero" aria-labelledby="ph-h" {!! \App\Models\PageHero::style('publication') !!}>
  <div class="container">
    <nav class="breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
    </nav>
    <div class="page-hero-grid">
      <div>
        <h1 class="page-hero-title" id="ph-h">@lang('site.pgs_not_found')</h1>
        <p class="page-hero-sub">@lang('site.pgs_not_found_sub')</p>
      </div>
    </div>
  </div>
</section>

@endif
@endsection

@push('scripts')
<script>
(function(){
  // Reading progress bar
  var progress = document.getElementById('pubxProgress');
  var doc      = document.getElementById('pubxDoc');
  if(progress && doc){
    var bar = progress.querySelector('span');
    var update = function(){
      var rect = doc.getBoundingClientRect();
      var top  = window.scrollY + rect.top;
      var max  = rect.height - window.innerHeight;
      if(max <= 0){ bar.style.width = '0%'; return; }
      var pct = Math.min(100, Math.max(0, ((window.scrollY - top) / max) * 100));
      bar.style.width = pct + '%';
    };
    window.addEventListener('scroll', update, {passive:true});
    window.addEventListener('resize', update);
    update();
  }

  // Copy link button
  var copyBtn = document.getElementById('pubxCopyLink');
  if(copyBtn){
    copyBtn.addEventListener('click', function(){
      navigator.clipboard.writeText(location.href).then(function(){
        copyBtn.classList.add('is-done');
        setTimeout(function(){ copyBtn.classList.remove('is-done'); }, 1600);
      });
    });
  }

  // Hero particles — drift freely; gather toward cursor on hover; resume drift on leave
  (function initParticles(){
    var canvas = document.getElementById('pubxParticles');
    if(!canvas) return;
    var hero = canvas.closest('.pubx-hero');
    if(!hero) return;

    // Respect reduced motion
    if(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var ctx = canvas.getContext('2d');
    var dpr = Math.max(1, Math.min(2, window.devicePixelRatio || 1));
    var w = 0, h = 0;
    var particles = [];
    var mouse = { x: -9999, y: -9999, active: false };
    var raf = null;

    function resize(){
      var rect = hero.getBoundingClientRect();
      w = rect.width; h = rect.height;
      canvas.width  = Math.floor(w * dpr);
      canvas.height = Math.floor(h * dpr);
      canvas.style.width  = w + 'px';
      canvas.style.height = h + 'px';
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function build(){
      var area = w * h;
      var count = Math.max(40, Math.min(110, Math.round(area / 14000)));
      particles = [];
      for(var i=0; i<count; i++){
        particles.push({
          x: Math.random() * w,
          y: Math.random() * h,
          vx: (Math.random() - 0.5) * 1.2,
          vy: (Math.random() - 0.5) * 1.2,
          r: Math.random() * 1.6 + 0.6,
          a: Math.random() * 0.5 + 0.35,
          hue: Math.random() < 0.55 ? 'gold' : 'blue'
        });
      }
    }

    function step(){
      ctx.clearRect(0, 0, w, h);

      var mx = mouse.x, my = mouse.y, active = mouse.active;
      var attractRadius = 220;
      var attractRadiusSq = attractRadius * attractRadius;

      for(var i=0; i<particles.length; i++){
        var p = particles[i];

        if(active){
          var dx = mx - p.x;
          var dy = my - p.y;
          var distSq = dx*dx + dy*dy;
          if(distSq < attractRadiusSq){
            var dist = Math.sqrt(distSq) || 0.0001;
            var force = (1 - dist / attractRadius) * 0.18;
            p.vx += (dx / dist) * force;
            p.vy += (dy / dist) * force;
          }
        }

        // light damping — only kicks in strongly during attraction
        p.vx *= active ? 0.94 : 0.992;
        p.vy *= active ? 0.94 : 0.992;

        // baseline drift so particles keep moving briskly
        p.vx += (Math.random() - 0.5) * 0.08;
        p.vy += (Math.random() - 0.5) * 0.08;

        // cap idle speed so motion stays elegant, not chaotic
        if(!active){
          var sp = Math.sqrt(p.vx*p.vx + p.vy*p.vy);
          var maxSp = 1.6;
          if(sp > maxSp){ p.vx = p.vx / sp * maxSp; p.vy = p.vy / sp * maxSp; }
        }

        p.x += p.vx;
        p.y += p.vy;

        // wrap edges softly
        if(p.x < -10) p.x = w + 10;
        else if(p.x > w + 10) p.x = -10;
        if(p.y < -10) p.y = h + 10;
        else if(p.y > h + 10) p.y = -10;

        var color = p.hue === 'gold'
          ? 'rgba(201,169,97,' + p.a + ')'
          : 'rgba(126,200,245,' + p.a + ')';
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = color;
        ctx.fill();
      }

      // draw subtle links between nearby particles
      ctx.lineWidth = 0.6;
      for(var i=0; i<particles.length; i++){
        for(var j=i+1; j<particles.length; j++){
          var a = particles[i], b = particles[j];
          var dx2 = a.x - b.x, dy2 = a.y - b.y;
          var d2  = dx2*dx2 + dy2*dy2;
          if(d2 < 9000){
            var alpha = (1 - d2 / 9000) * 0.18;
            ctx.strokeStyle = 'rgba(201,169,97,' + alpha + ')';
            ctx.beginPath();
            ctx.moveTo(a.x, a.y);
            ctx.lineTo(b.x, b.y);
            ctx.stroke();
          }
        }
      }

      raf = requestAnimationFrame(step);
    }

    function onMove(e){
      var rect = hero.getBoundingClientRect();
      mouse.x = e.clientX - rect.left;
      mouse.y = e.clientY - rect.top;
      mouse.active = true;
    }
    function onLeave(){ mouse.active = false; mouse.x = -9999; mouse.y = -9999; }

    hero.addEventListener('mousemove', onMove);
    hero.addEventListener('mouseleave', onLeave);
    hero.addEventListener('touchmove', function(e){
      if(!e.touches || !e.touches.length) return;
      var rect = hero.getBoundingClientRect();
      mouse.x = e.touches[0].clientX - rect.left;
      mouse.y = e.touches[0].clientY - rect.top;
      mouse.active = true;
    }, {passive:true});
    hero.addEventListener('touchend', onLeave);

    var resizeTimer;
    window.addEventListener('resize', function(){
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function(){ resize(); build(); }, 120);
    });

    resize();
    build();
    step();
  })();

  // Copy citation button
  var citeBtn  = document.getElementById('pubxCiteCopy');
  var citeText = document.getElementById('pubxCiteText');
  if(citeBtn && citeText){
    citeBtn.addEventListener('click', function(){
      var text = (citeText.innerText || citeText.textContent || '').trim();
      navigator.clipboard.writeText(text).then(function(){
        citeBtn.classList.add('is-done');
        var lbl = citeBtn.querySelector('span');
        var prev = lbl.textContent;
        lbl.textContent = 'Copied';
        setTimeout(function(){
          citeBtn.classList.remove('is-done');
          lbl.textContent = prev;
        }, 1600);
      });
    });
  }
})();
</script>
@endpush
