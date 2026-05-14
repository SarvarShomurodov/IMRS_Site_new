@extends('client.journal_site.cabinet._layout')

@section('title', __('journal.cab.resubmit_title') . ' — IMRS Journal')

@section('cabinet')

<header class="jsite-cab-head">
  <a href="{{ route('journal.cabinet.article', $article->id) }}" class="jsite-link-soft jsite-cab-back">
    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    <span>@lang('journal.back')</span>
  </a>

  <p class="jsite-cab-eyebrow">№{{ $article->id }} · @lang('journal.status.'.$article->status)</p>
  <h1 class="jsite-cab-title">@lang('journal.cab.resubmit_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.cab.resubmit_sub')</p>
</header>

@if ($article->rejection_reason)
  <div class="jsite-alert {{ $article->status === 'revision_requested' ? 'jsite-alert-warn' : 'jsite-alert-err' }} jsite-alert-block">
    <strong>{{ $article->status === 'revision_requested' ? __('journal.cab.revision_reason') : __('journal.cab.rejection_reason') }}</strong>
    <p>{{ $article->rejection_reason }}</p>
  </div>
@endif

<form method="POST" action="{{ route('journal.cabinet.article.resubmit.post', $article->id) }}" enctype="multipart/form-data" class="jsite-auth-form jsite-cab-form" novalidate>
  @csrf

  {{-- Title --}}
  <div class="jsite-field @error('title') has-err @enderror">
    <label for="title">@lang('journal.cab.form_title') <span class="req">*</span></label>
    <div class="jsite-input">
      <input type="text" id="title" name="title" value="{{ old('title', $article->title_orig) }}" placeholder="@lang('journal.cab.form_title_ph')" required>
    </div>
    <p class="jsite-field-help">@lang('journal.cab.form_title_help')</p>
    @error('title')<p class="jsite-err">{{ $message }}</p>@enderror
  </div>

  {{-- Current file (for context) --}}
  <div class="jsite-field">
    <label>@lang('journal.cab.file') (joriy)</label>
    <div class="jsite-file-card" style="cursor:default;">
      <span class="jsite-file-card-ico">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </span>
      <div class="jsite-file-card-info">
        <strong>{{ $article->file_original_name }}</strong>
        @if ($article->file_size)
          <span>{{ number_format($article->file_size / 1024 / 1024, 2) }} MB</span>
        @endif
      </div>
    </div>
  </div>

  {{-- New file (optional) --}}
  <div class="jsite-field @error('file') has-err @enderror">
    <label for="file">@lang('journal.cab.form_file') <small style="font-weight:400;color:var(--t3);">— @lang('journal.cab.resubmit_keep_file')</small></label>

    <div class="jsite-file-drop" id="jsiteFileDrop">
      <input type="file" id="file" name="file" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" hidden>

      <div class="jsite-file-empty" data-empty>
        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        <p class="jsite-file-drop-title">@lang('journal.cab.form_file_drop')</p>
        <p class="jsite-file-drop-sub">@lang('journal.cab.form_file_help')</p>
      </div>

      <div class="jsite-file-chosen" data-chosen hidden>
        <span class="jsite-file-chosen-ico">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </span>
        <div class="jsite-file-chosen-info">
          <strong data-name></strong>
          <span data-size></span>
        </div>
        <button type="button" class="jsite-file-change" data-change>
          @lang('journal.cab.form_file_change')
        </button>
      </div>
    </div>

    @error('file')<p class="jsite-err">{{ $message }}</p>@enderror
  </div>

  <div class="jsite-cab-form-actions">
    <a href="{{ route('journal.cabinet.article', $article->id) }}" class="jsite-btn-ghost">
      @lang('journal.back')
    </a>
    <button type="submit" class="jsite-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
      <span>@lang('journal.cab.resubmit_btn')</span>
    </button>
  </div>

</form>

@endsection

@push('scripts')
<script>
(function(){
  var drop = document.getElementById('jsiteFileDrop');
  if (!drop) return;
  var input = drop.querySelector('input[type=file]');
  var emptyEl = drop.querySelector('[data-empty]');
  var chosenEl = drop.querySelector('[data-chosen]');
  var nameEl = drop.querySelector('[data-name]');
  var sizeEl = drop.querySelector('[data-size]');
  var changeBtn = drop.querySelector('[data-change]');

  function fmt(b) {
    if (b < 1024) return b + ' B';
    if (b < 1024*1024) return (b/1024).toFixed(1) + ' KB';
    return (b/1024/1024).toFixed(2) + ' MB';
  }
  function show(file) {
    nameEl.textContent = file.name;
    sizeEl.textContent = fmt(file.size);
    emptyEl.hidden = true; chosenEl.hidden = false;
  }
  function reset() {
    input.value = '';
    emptyEl.hidden = false; chosenEl.hidden = true;
  }
  drop.addEventListener('click', function(e){ if (e.target === changeBtn) return; input.click(); });
  changeBtn.addEventListener('click', function(e){ e.stopPropagation(); reset(); input.click(); });
  input.addEventListener('change', function(){ if (input.files && input.files[0]) show(input.files[0]); });
  ['dragenter','dragover'].forEach(function(ev){ drop.addEventListener(ev, function(e){ e.preventDefault(); e.stopPropagation(); drop.classList.add('is-drag'); }); });
  ['dragleave','drop'].forEach(function(ev){ drop.addEventListener(ev, function(e){ e.preventDefault(); e.stopPropagation(); drop.classList.remove('is-drag'); }); });
  drop.addEventListener('drop', function(e){ if (e.dataTransfer && e.dataTransfer.files.length) { input.files = e.dataTransfer.files; show(e.dataTransfer.files[0]); } });
})();
</script>
@endpush
