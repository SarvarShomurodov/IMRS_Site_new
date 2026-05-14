@extends('client.layouts.app')

{{-- @section('metadata')
  <title>{{ $item ? $item->getTitleAttribute() : '' }} | @lang('index.index')</title>
  <meta name="description" content="{{ $item ? $item->getMetaDescription() : '' }}">
  <meta name="keywords" content="{{ $item ? $item->getMetaKeyword() : '' }}">
  <meta property="og:title" content="{{ $item ? $item->getTitleAttribute() : '' }} | @lang('index.index')">
  <meta property="og:description" content="{{ $item ? $item->getMetaDescription() : '' }}">
  @if($item && $item->issetImage())
    <meta property="og:image" content="{{ $item->getImageAttribute() }}">
  @endif
@endsection --}}

@section('content')
@if($item)
@php
  $category = $item->categories->first();
  $dt       = \Carbon\Carbon::parse($item->created_at);
  $dt->locale(app()->getLocale());
@endphp

<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="@lang('site.laws_breadcrumb_aria')">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      @if($category)
        <a href="{{ route('pages', $category->slug) }}">{{ $category->getTitleAttribute() }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      @endif
      <span aria-current="page">{{ $item->getTitleAttribute() }}</span>
    </nav>

    <div class="page-hero-grid">
      <div>
        @if($category)
          <p class="page-hero-eyebrow" data-aos="fade-up">{{ $category->getTitleAttribute() }}</p>
        @endif
        <h1 class="page-hero-title" id="ph-h" data-aos="fade-up" data-aos-delay="80">
          <em>{{ $item->getTitleAttribute() }}</em>
        </h1>
        @if($item->getMetaDescription())
          <p class="page-hero-sub" data-aos="fade-up" data-aos-delay="160">{{ $item->getMetaDescription() }}</p>
        @endif
      </div>

      <aside class="page-hero-meta" data-aos="fade-left" data-aos-delay="200">
        <div class="stat">
          <div class="snum"><span>{{ $dt->format('d') }}</span></div>
          <div class="slbl">{{ $dt->translatedFormat('M Y') }}</div>
        </div>
        @if(!empty($item->views))
          <div class="stat">
            <div class="snum"><span>{{ $item->views }}</span></div>
            <div class="slbl">@lang('site.views')</div>
          </div>
        @endif
        @if($item->issetPdf() || $item->issetVideo())
          <div class="stat">
            <div class="snum"><span>{{ ($item->issetPdf() ? 1 : 0) + ($item->issetVideo() ? 1 : 0) }}</span></div>
            <div class="slbl">@lang('site.attached_files')</div>
          </div>
        @endif
        @if($category)
          <div class="stat">
            <div class="snum"><span>—</span></div>
            <div class="slbl">{{ $category->getTitleAttribute() }}</div>
          </div>
        @endif
      </aside>
    </div>
  </div>
</section>

<!-- ── ARTICLE BODY ── -->
<section id="page-body" aria-labelledby="pb-h">
  <div class="container">
    <article class="page-article" data-aos="fade-up">
      @if($item->issetImage())
        <figure class="page-article-img">
          <img src="{{ $item->getImageAttribute() }}" alt="{{ $item->getTitleAttribute() }}" loading="lazy">
        </figure>
      @endif

      @if($item->issetDescription())
        @php
          $description = $item->getDescriptionAttribute();
          // Mutlaq URL'larda /public/ ni olib tashlash: https://imrs.uz/public/... → https://imrs.uz/...
          $description = preg_replace('#((?:src|href)\s*=\s*["\'])((?:https?:)?//[^"\']+)/public/#i', '$1$2/', $description);
          // Nisbiy yo'llarda /public/ yoki public/ ni / ga aylantirish
          $description = preg_replace('#((?:src|href)\s*=\s*["\'])/?public/#i', '$1/', $description);
          // Rasmlarga lazy loading qo'shish (agar yo'q bo'lsa)
          $description = preg_replace('#<img(?![^>]*\sloading=)#i', '<img loading="lazy"', $description);
        @endphp
        <div class="page-article-content">
          {!! $description !!}
        </div>
      @endif

      @if($item->issetPdf())
        <div class="page-article-pdf" data-aos="fade-up">
          <div class="pdf-head">
            <div class="pdf-ico">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div class="pdf-info">
              <span class="pdf-label">PDF</span>
              <span class="pdf-name">{{ $item->getTitleAttribute() }}</span>
            </div>
            <a class="btn-p" href="{{ $item->getPdfAttribute() }}" target="_blank" rel="noopener">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              @if($item->isVacancy()) @lang('index.example') @else @lang('index.download') @endif
            </a>
          </div>
          <iframe src="{{ $item->getPdfAttribute() }}" class="pdf-frame" loading="lazy"></iframe>
        </div>
      @endif

      @if($item->issetVideo())
        <div class="page-article-video" data-aos="fade-up">
          <div class="video-frame">
            <iframe src="{{ $item->getVideo() }}?feature=oembed&amp;rel=0&amp;modestbranding=1" allowfullscreen title="{{ $item->getTitleAttribute() }}"></iframe>
          </div>
        </div>
      @endif

      <div class="page-article-foot">
        <div class="foot-meta">
          <span class="foot-date">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            {{ $item->getCreatedData() }}
          </span>
          @if(!empty($item->views))
            <span class="foot-views">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              {{ $item->views }} @lang('site.views')
            </span>
          @endif
        </div>
        <div class="foot-share">
          <script src="https://yastatic.net/share2/share.js"></script>
          <div class="ya-share2" data-curtain data-shape="round" data-services="vkontakte,facebook,odnoklassniki,telegram,twitter"></div>
        </div>
      </div>
    </article>

    @if($item1 || $item2)
      <nav class="page-nav" aria-label="@lang('index.navigation')" data-aos="fade-up">
        @if($item1)
          <a class="page-nav-item page-nav-prev" href="{{ route('page', [$item1->slug]) }}" rel="prev">
            <span class="page-nav-arrow" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            </span>
            <span class="nav-text">
              <span class="nav-label">@lang('index.back')</span>
              <span class="nav-title">{{ $item1->getTitleAttribute() }}</span>
            </span>
          </a>
        @else
          <span></span>
        @endif
        @if($item2)
          <a class="page-nav-item page-nav-next" href="{{ route('page', [$item2->slug]) }}" rel="next">
            <span class="nav-text">
              <span class="nav-label">@lang('index.forward')</span>
              <span class="nav-title">{{ $item2->getTitleAttribute() }}</span>
            </span>
            <span class="page-nav-arrow" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </a>
        @endif
      </nav>
    @endif
  </div>
</section>

@else

<!-- Sahifa topilmadi -->
<section class="page-hero" aria-labelledby="ph-h">
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

<style>
/* ═══════════════════════════════════════════════
   PAGE single — section spacing & content
═══════════════════════════════════════════════ */
#page-body{
  padding:6rem 0;
  position:relative;
  background:var(--bg);
}
.page-article{
  max-width:880px;margin:0 auto;
}
.page-article-img{
  margin:0 0 2rem;border-radius:14px;overflow:hidden;
  box-shadow:0 22px 60px rgba(8,15,30,.16),0 4px 14px rgba(8,15,30,.08);
}
.page-article-img img{width:100%;height:auto;display:block}

/* Article rich text content — saytdagi uslub (CKEditor formatlash yumshatildi) */
.page-article-content{
  font-family:var(--sans);
  font-size:1.05rem;line-height:1.82;color:var(--t1);
  font-weight:400;letter-spacing:0;
  margin-bottom:2rem;
}
.page-article-content *{
  text-align:inherit !important;
  font-family:inherit !important;
  font-size:inherit !important;
  font-weight:400 !important;
  background:transparent !important;
}
.page-article-content p,
.page-article-content div{
  margin:0 0 1.15rem;text-align:left !important;color:var(--t1);
}
.page-article-content p:last-child{margin-bottom:0}
.page-article-content h2,
.page-article-content h3,
.page-article-content h4{
  font-family:var(--serif,Georgia,serif) !important;
  font-weight:700 !important;letter-spacing:-.2px;line-height:1.25;
  margin:1.9rem 0 .85rem;color:var(--t1);text-align:left !important;
}
.page-article-content h2{font-size:1.5rem}
.page-article-content h3{font-size:1.25rem}
.page-article-content h4{font-size:1.08rem;color:var(--blue-mid,#2563a8)}
.page-article-content ul,
.page-article-content ol{margin:0 0 1.2rem 1.5rem;padding:0}
.page-article-content li{margin-bottom:.55rem;line-height:1.78}
.page-article-content li::marker{color:var(--gold,#c9a961)}
.page-article-content strong,
.page-article-content b{color:inherit !important;font-weight:400 !important}
.page-article-content a{
  color:var(--blue-mid,#2563a8) !important;font-weight:400 !important;
  text-decoration:none;border-bottom:1px solid rgba(37,99,168,.25);
  transition:border-color .25s;
}
.page-article-content a:hover{border-bottom-color:var(--gold,#c9a961)}
[data-theme="dark"] .page-article-content a{
  color:#7ec8f5 !important;border-bottom-color:rgba(126,200,245,.3);
}
.page-article-content img{
  max-width:100%;height:auto;border-radius:10px;
  margin:1.4rem auto;display:block;
  box-shadow:0 12px 28px rgba(8,15,30,.1);
}
.page-article-content blockquote{
  margin:1.4rem 0;padding:1.1rem 1.5rem;
  border-left:3px solid var(--gold,#c9a961);
  background:rgba(201,169,97,.05);border-radius:0 12px 12px 0;
  font-style:italic;color:var(--t2);
}

/* PDF preview */
.page-article-pdf{
  margin:2.5rem 0;border-radius:16px;overflow:hidden;
  border:1px solid rgba(37,99,168,.12);
  background:linear-gradient(160deg,rgba(255,255,255,.7),rgba(248,250,253,.55));
  box-shadow:0 12px 38px rgba(8,15,30,.08);
}
[data-theme="dark"] .page-article-pdf{
  background:linear-gradient(160deg,rgba(255,255,255,.05),rgba(255,255,255,.02));
  border-color:rgba(126,200,245,.14);
}
.pdf-head{
  display:flex;align-items:center;gap:1rem;
  padding:1.1rem 1.4rem;
  border-bottom:1px solid rgba(37,99,168,.12);
}
.pdf-ico{
  width:42px;height:42px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,rgba(37,99,168,.12),rgba(201,169,97,.12));
  display:flex;align-items:center;justify-content:center;
  color:var(--blue-mid,#2563a8);
  border:1px solid rgba(255,255,255,.4);
}
.pdf-ico svg{width:20px;height:20px}
.pdf-info{flex:1;display:flex;flex-direction:column;gap:.22rem;min-width:0}
.pdf-label{font-size:.7rem;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;color:var(--gold,#c9a961)}
.pdf-name{font-size:.95rem;font-weight:600;color:var(--t1);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.pdf-frame{width:100%;height:720px;border:none;display:block;background:#0d1e30}

/* Video embed */
.page-article-video{margin:2rem 0}
.video-frame{
  position:relative;aspect-ratio:16/9;border-radius:14px;overflow:hidden;
  box-shadow:0 22px 60px rgba(8,15,30,.18);background:#0d1e30;
}
.video-frame iframe{position:absolute;inset:0;width:100%;height:100%;border:none}

/* Footer meta */
.page-article-foot{
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;
  margin-top:2.5rem;padding-top:1.3rem;
  border-top:1px solid var(--bdr);
  font-size:.86rem;color:var(--t2);
}
.foot-meta{display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap}
.foot-date,.foot-views{display:inline-flex;align-items:center;gap:.45rem}

/* Prev / next navigation */
.page-nav{
  display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;
  max-width:880px;margin:3rem auto 0;
  padding-top:2rem;border-top:1px solid var(--bdr);
}
.page-nav-item{
  display:grid;grid-template-columns:auto 1fr;gap:.55rem 1rem;
  padding:1.2rem 1.4rem;border-radius:14px;
  background:rgba(255,255,255,.55);
  border:1px solid rgba(37,99,168,.12);
  text-decoration:none;color:var(--t1);
  transition:transform .35s cubic-bezier(.22,1,.36,1),border-color .25s,background .25s,box-shadow .25s;
}
[data-theme="dark"] .page-nav-item{background:rgba(255,255,255,.04);color:#e8eef9}
.page-nav-prev > svg{grid-row:1/3;align-self:center;width:18px;height:18px;color:var(--blue-mid,#2563a8)}
.page-nav-next{grid-template-columns:1fr auto;text-align:right}
.page-nav-next > svg{grid-row:1/3;align-self:center;grid-column:2;width:18px;height:18px;color:var(--blue-mid,#2563a8)}
[data-theme="dark"] .page-nav-prev > svg,
[data-theme="dark"] .page-nav-next > svg{color:#7ec8f5}
.page-nav-item:hover{
  transform:translateY(-3px);
  border-color:rgba(37,99,168,.34);background:#fff;
  box-shadow:0 18px 40px rgba(8,15,30,.12);
}
[data-theme="dark"] .page-nav-item:hover{background:rgba(255,255,255,.08);border-color:rgba(126,200,245,.32)}
.nav-label{
  font-size:.7rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;
  color:var(--blue-mid,#2563a8);
}
[data-theme="dark"] .nav-label{color:#7ec8f5}
.nav-title{
  font-family:var(--serif,Georgia,serif);
  font-size:1rem;font-weight:600;line-height:1.4;color:var(--t1);
  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
[data-theme="dark"] .nav-title{color:#fff}

@media(max-width:760px){
  .page-nav{grid-template-columns:1fr}
  .page-nav-next{grid-template-columns:auto 1fr;text-align:left}
  .page-nav-next > svg{grid-column:1}
  .pdf-frame{height:460px}
}
</style>
@endsection
