@extends('client.journal_site.cabinet._layout')

@section('title', __('journal.cab.submit_title') . ' — IMRS Journal')

@section('cabinet')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">@lang('journal.cab.submit_new')</p>
  <h1 class="jsite-cab-title">@lang('journal.cab.submit_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.cab.submit_sub')</p>
</header>

<form method="POST" action="{{ route('journal.cabinet.submit.post') }}" enctype="multipart/form-data" class="jsite-auth-form jsite-cab-form" novalidate>
  @csrf

  {{-- Title --}}
  <div class="jsite-field @error('title') has-err @enderror">
    <label for="title">@lang('journal.cab.form_title') <span class="req">*</span></label>
    <div class="jsite-input">
      <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="@lang('journal.cab.form_title_ph')" required>
    </div>
    <p class="jsite-field-help">@lang('journal.cab.form_title_help')</p>
    @error('title')<p class="jsite-err">{{ $message }}</p>@enderror
  </div>

  {{-- File --}}
  <div class="jsite-field @error('file') has-err @enderror">
    <label for="file">@lang('journal.cab.form_file') <span class="req">*</span></label>

    <div class="jsite-file-drop" id="jsiteFileDrop">
      <input type="file" id="file" name="file" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required hidden>

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
    <a href="{{ route('journal.cabinet') }}" class="jsite-btn-ghost">
      @lang('journal.back')
    </a>
    <button type="submit" class="jsite-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
      <span>@lang('journal.cab.submit_btn')</span>
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
    emptyEl.hidden = true;
    chosenEl.hidden = false;
  }
  function reset() {
    input.value = '';
    emptyEl.hidden = false;
    chosenEl.hidden = true;
  }

  drop.addEventListener('click', function(e){
    if (e.target === changeBtn) return;
    input.click();
  });
  changeBtn.addEventListener('click', function(e){
    e.stopPropagation();
    reset();
    input.click();
  });

  input.addEventListener('change', function(){
    if (input.files && input.files[0]) show(input.files[0]);
  });

  ['dragenter','dragover'].forEach(function(ev){
    drop.addEventListener(ev, function(e){
      e.preventDefault(); e.stopPropagation();
      drop.classList.add('is-drag');
    });
  });
  ['dragleave','drop'].forEach(function(ev){
    drop.addEventListener(ev, function(e){
      e.preventDefault(); e.stopPropagation();
      drop.classList.remove('is-drag');
    });
  });
  drop.addEventListener('drop', function(e){
    if (e.dataTransfer && e.dataTransfer.files.length) {
      input.files = e.dataTransfer.files;
      show(e.dataTransfer.files[0]);
    }
  });
})();
</script>
@endpush
