@extends('client.journal_site.moderator._layout')

@section('title', __('journal.mod.issues_title'))

@section('panel')

<header class="jsite-panel-head">
  <div>
    <p class="jsite-panel-eyebrow">@lang('journal.mod.panel')</p>
    <h1 class="jsite-panel-title">@lang('journal.mod.issues_title')</h1>
    <p class="jsite-panel-sub">@lang('journal.mod.issues_sub')</p>
  </div>
</header>

{{-- Upload form --}}
<section class="jsite-issues-form-wrap">
  <h2 class="jsite-issues-form-title">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    @lang('journal.mod.issue_upload_title')
  </h2>

  <form action="{{ route('journal.moderator.issues.store') }}" method="POST" enctype="multipart/form-data" class="jsite-issues-form">
    @csrf

    <div class="jsite-issues-form-grid">
      <label class="jsite-fld">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_title_uz') <em>*</em></span>
        <input type="text" name="title_uz" value="{{ old('title_uz') }}" required maxlength="255">
        @error('title_uz') <span class="jsite-fld-err">{{ $message }}</span> @enderror
      </label>
      <label class="jsite-fld">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_title_ru') <em>*</em></span>
        <input type="text" name="title_ru" value="{{ old('title_ru') }}" required maxlength="255">
        @error('title_ru') <span class="jsite-fld-err">{{ $message }}</span> @enderror
      </label>
      <label class="jsite-fld">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_title_en') <em>*</em></span>
        <input type="text" name="title_en" value="{{ old('title_en') }}" required maxlength="255">
        @error('title_en') <span class="jsite-fld-err">{{ $message }}</span> @enderror
      </label>

      <label class="jsite-fld">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_period_uz')</span>
        <input type="text" name="time_uz" value="{{ old('time_uz') }}" placeholder="@lang('journal.mod.issue_period_ph')" maxlength="120">
      </label>
      <label class="jsite-fld">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_period_ru')</span>
        <input type="text" name="time_ru" value="{{ old('time_ru') }}" placeholder="@lang('journal.mod.issue_period_ph')" maxlength="120">
      </label>
      <label class="jsite-fld">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_period_en')</span>
        <input type="text" name="time_en" value="{{ old('time_en') }}" placeholder="@lang('journal.mod.issue_period_ph')" maxlength="120">
      </label>

      <label class="jsite-fld">
        <span class="jsite-fld-lbl">ISSN</span>
        <input type="text" name="issn" value="{{ old('issn') }}" maxlength="60" placeholder="2181-XXXX">
      </label>
      <label class="jsite-fld">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_sort')</span>
        <input type="number" name="sort" value="{{ old('sort', 1) }}" min="0" max="255">
      </label>
      <span class="jsite-fld jsite-fld-spacer" aria-hidden="true"></span>

      <label class="jsite-fld jsite-fld-file">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_cover') <span class="jsite-fld-hint">JPG/PNG · ≤ 5 MB</span></span>
        <input type="file" name="image" accept="image/*">
        @error('image') <span class="jsite-fld-err">{{ $message }}</span> @enderror
      </label>
      <label class="jsite-fld jsite-fld-file jsite-fld-file-pdf">
        <span class="jsite-fld-lbl">@lang('journal.mod.issue_pdf') <em>*</em> <span class="jsite-fld-hint">PDF · ≤ 30 MB</span></span>
        <input type="file" name="pdf" accept="application/pdf" required>
        @error('pdf') <span class="jsite-fld-err">{{ $message }}</span> @enderror
      </label>
    </div>

    <div class="jsite-issues-form-actions">
      <button type="submit" class="jsite-btn jsite-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        <span>@lang('journal.mod.issue_publish')</span>
      </button>
    </div>
  </form>
</section>

{{-- List --}}
<section class="jsite-issues-list-wrap">
  <div class="jsite-issues-list-head">
    <h2>@lang('journal.mod.issues_list')</h2>
    <span class="jsite-issues-list-count">{{ $issues->total() }}</span>
  </div>

  @if($issues->isEmpty())
    <p class="jsite-issues-list-empty">@lang('journal.mod.issues_empty')</p>
  @else
    <ul class="jsite-issues-mod-list" role="list">
      @foreach($issues as $iss)
        @php
          $coverUrl = !empty($iss->image) ? asset('images/journals/' . $iss->image) : null;
          $titleI   = $iss->getTitleAttribute();
          $pdfUrl   = !empty($iss->journal) ? asset('files/journals/' . $iss->journal) : null;
        @endphp
        <li class="jsite-issues-mod-row">
          <div class="jsite-issues-mod-cover">
            @if($coverUrl)
              <img src="{{ $coverUrl }}" alt="">
            @else
              <div class="jsite-issues-mod-cover-fb">№{{ $iss->id }}</div>
            @endif
          </div>
          <div class="jsite-issues-mod-info">
            <h3>{{ $titleI }}</h3>
            <div class="jsite-issues-mod-meta">
              <span>№{{ $iss->id }}</span>
              @if(!empty($iss->issn))<span>ISSN {{ $iss->issn }}</span>@endif
              @if($iss->getTimeAttribute())<span>{{ $iss->getTimeAttribute() }}</span>@endif
              <span>{{ number_format((int) ($iss->views ?? 0)) }} @lang('journal.show.meta_views')</span>
            </div>
          </div>
          <div class="jsite-issues-mod-actions">
            <a class="jsite-issues-mod-act" href="{{ route('journal.issue', $iss->id) }}" target="_blank" rel="noopener" title="@lang('journal.issues.read')">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </a>
            @if($pdfUrl)
              <a class="jsite-issues-mod-act" href="{{ $pdfUrl }}" target="_blank" rel="noopener" title="@lang('journal.issues.download')" download>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              </a>
            @endif
            <form method="POST" action="{{ route('journal.moderator.issues.destroy', $iss->id) }}" class="jsite-issues-mod-del-frm" onsubmit="return confirm('@lang('journal.mod.issue_delete_confirm')');">
              @csrf
              @method('DELETE')
              <button type="submit" class="jsite-issues-mod-act jsite-issues-mod-act-del" title="@lang('journal.mod.issue_delete')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
              </button>
            </form>
          </div>
        </li>
      @endforeach
    </ul>

    @if($issues->hasPages())
      <nav class="jsite-pager" aria-label="Pagination">
        @if($issues->onFirstPage())
          <span class="jsite-pager-btn is-disabled" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          </span>
        @else
          <a class="jsite-pager-btn" href="{{ $issues->previousPageUrl() }}" rel="prev" aria-label="Previous">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          </a>
        @endif

        @foreach(range(1, $issues->lastPage()) as $p)
          @if($p === $issues->currentPage())
            <span class="jsite-pager-num is-act" aria-current="page">{{ $p }}</span>
          @else
            <a class="jsite-pager-num" href="{{ $issues->url($p) }}">{{ $p }}</a>
          @endif
        @endforeach

        @if($issues->hasMorePages())
          <a class="jsite-pager-btn" href="{{ $issues->nextPageUrl() }}" rel="next" aria-label="Next">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        @else
          <span class="jsite-pager-btn is-disabled" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
          </span>
        @endif
      </nav>
    @endif
  @endif
</section>

@endsection
