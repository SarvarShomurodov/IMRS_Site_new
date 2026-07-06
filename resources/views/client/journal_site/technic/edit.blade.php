@extends('client.journal_site.technic._layout')

@section('title', __('journal.tec.edit_published') . ' — IMRS Journal')

@section('panel')

<a href="{{ route('journal.technic.all', ['status' => 'published']) }}" class="jsite-link-soft jsite-cab-back">
  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
  <span>@lang('journal.back')</span>
</a>

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">№{{ $article->id }} · {{ $article->author->fullName() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.tec.edit_published')</h1>
  <p class="jsite-cab-sub">@lang('journal.tec.edit_published_sub')</p>
</header>

<section class="jsite-cab-block jsite-tec-action-block is-publish">
  <form method="POST" action="{{ route('journal.technic.article.update', $article->id) }}" enctype="multipart/form-data" class="jsite-auth-form jsite-cab-form">
    @csrf

    {{-- Read-only: original (submitted) title --}}
    <div class="jsite-field">
      <label>@lang('journal.cab.article_title')</label>
      <div class="jsite-readonly-pill">{{ $article->title_orig }}</div>
    </div>

    {{-- Ko'p tilli nashr maydonlari --}}
    @include('client.journal_site.technic._publish-localized-fields', ['article' => $article])

    <div class="jsite-cab-form-actions">
      <button type="submit" class="jsite-btn-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        <span>@lang('journal.tec.btn_save')</span>
      </button>
      <a href="{{ route('journal.technic.all', ['status' => 'published']) }}" class="jsite-btn-ghost">@lang('journal.tec.btn_cancel')</a>
    </div>
  </form>
</section>

@endsection
