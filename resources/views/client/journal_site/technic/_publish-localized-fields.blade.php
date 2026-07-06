{{--
  Ko'p tilli nashr maydonlari (texnik publish / edit formalari uchun).
  $article — JournalArticle. Hamma maydonlar ixtiyoriy.
--}}
@php
  $jLangs = ['uz' => "O'zbekcha", 'ru' => 'Русский', 'en' => 'English'];
@endphp

<style>
  .jsite-lang-tabs { display:flex; gap:.4rem; margin-bottom:.35rem; flex-wrap:wrap; }
  .jsite-lang-tab {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.5rem .95rem; border:1px solid var(--bdr); border-radius:8px;
    background:transparent; color:var(--t2); font-weight:600; font-size:.85rem;
    cursor:pointer; transition:background .15s, border-color .15s, color .15s;
  }
  .jsite-lang-tab:hover { color:var(--t1); border-color:var(--t3); }
  .jsite-lang-tab.is-act {
    background:var(--blue-dark); border-color:var(--blue-dark); color:#fff;
  }
  .jsite-lang-tab .jsite-lang-dot {
    width:7px; height:7px; border-radius:50%; background:#16a34a; display:inline-block;
  }
  .jsite-lang-panel { display:none; }
  .jsite-lang-panel.is-act { display:block; }
</style>

{{-- Language tabs --}}
<div class="jsite-lang-tabs" role="tablist" id="jsitePubLangTabs">
  @foreach ($jLangs as $lng => $lngLabel)
    @php
      $hasContent = filled($article->{'title_publish_'.$lng}) || filled($article->{'description_'.$lng}) || filled($article->{'cover_'.$lng});
    @endphp
    <button type="button" class="jsite-lang-tab @if($loop->first) is-act @endif" data-lang-tab="{{ $lng }}" role="tab">
      {{ $lngLabel }}
      @if($hasContent)<span class="jsite-lang-dot" aria-hidden="true" title="@lang('journal.tec.lang_filled')"></span>@endif
    </button>
  @endforeach
</div>
<p class="jsite-field-help" style="margin-bottom:1.1rem;">@lang('journal.tec.multilang_help')</p>

@foreach ($jLangs as $lng => $lngLabel)
  <div class="jsite-lang-panel @if($loop->first) is-act @endif" data-lang-panel="{{ $lng }}">

    {{-- Title for publication --}}
    <div class="jsite-field @error('title_publish_'.$lng) has-err @enderror">
      <label for="title_publish_{{ $lng }}">@lang('journal.tec.publish_title') · {{ $lngLabel }}</label>
      <div class="jsite-input">
        <input type="text" id="title_publish_{{ $lng }}" name="title_publish_{{ $lng }}"
               value="{{ old('title_publish_'.$lng, $article->{'title_publish_'.$lng}) }}"
               placeholder="@lang('journal.tec.publish_title_ph')">
      </div>
      @error('title_publish_'.$lng)<p class="jsite-err">{{ $message }}</p>@enderror
    </div>

    {{-- Description --}}
    <div class="jsite-field @error('description_'.$lng) has-err @enderror">
      <label for="description_{{ $lng }}">@lang('journal.tec.description') · {{ $lngLabel }}</label>
      <textarea name="description_{{ $lng }}" id="description_{{ $lng }}" class="jsite-textarea" rows="3" maxlength="500"
                placeholder="@lang('journal.tec.description_ph')">{{ old('description_'.$lng, $article->{'description_'.$lng}) }}</textarea>
      <p class="jsite-field-help">@lang('journal.tec.description_help')</p>
      @error('description_'.$lng)<p class="jsite-err">{{ $message }}</p>@enderror
    </div>

    {{-- Cover --}}
    <div class="jsite-field @error('cover_'.$lng) has-err @enderror">
      <label for="cover_{{ $lng }}">@lang('journal.tec.cover') · {{ $lngLabel }}</label>

      <div class="jsite-file-drop" data-cover-drop>
        <input type="file" id="cover_{{ $lng }}" name="cover_{{ $lng }}" accept="image/jpeg,image/png" hidden>
        <div class="jsite-file-empty" data-empty>
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <p class="jsite-file-drop-title">@lang('journal.tec.cover_drop')</p>
          <p class="jsite-file-drop-sub">@lang('journal.tec.cover_help')</p>
        </div>
        <div class="jsite-file-chosen" data-chosen hidden>
          <span class="jsite-file-chosen-ico">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </span>
          <div class="jsite-file-chosen-info">
            <strong data-name></strong>
            <span data-size></span>
          </div>
          <button type="button" class="jsite-file-change" data-change>@lang('journal.tec.cover_change')</button>
        </div>
        <img class="jsite-file-preview" data-preview hidden>
      </div>

      @if ($article->{'cover_'.$lng})
        <div style="margin-top:.6rem;">
          <span class="jsite-field-help">@lang('journal.tec.current_cover'):</span>
          <img src="{{ asset('storage/'.$article->{'cover_'.$lng}) }}" alt="" style="max-width:200px;border-radius:8px;display:block;margin-top:.35rem;">
        </div>
      @endif

      @error('cover_'.$lng)<p class="jsite-err">{{ $message }}</p>@enderror
    </div>

  </div>
@endforeach

{{-- Publish date (til-neytral, majburiy) --}}
<div class="jsite-field @error('publish_date') has-err @enderror">
  <label for="publish_date">@lang('journal.tec.publish_date') <span class="req">*</span></label>
  <div class="jsite-input">
    <input type="date" id="publish_date" name="publish_date"
           value="{{ old('publish_date', optional($article->publish_date)->format('Y-m-d') ?: now()->format('Y-m-d')) }}" required>
  </div>
  @error('publish_date')<p class="jsite-err">{{ $message }}</p>@enderror
</div>

<script>
(function(){
  /* ── Language tab switching ──────────────────── */
  var tabs = document.querySelectorAll('#jsitePubLangTabs [data-lang-tab]');
  var panels = document.querySelectorAll('[data-lang-panel]');
  function activate(lng){
    tabs.forEach(function(t){ t.classList.toggle('is-act', t.dataset.langTab === lng); });
    panels.forEach(function(p){ p.classList.toggle('is-act', p.dataset.langPanel === lng); });
  }
  tabs.forEach(function(t){
    t.addEventListener('click', function(){ activate(t.dataset.langTab); });
  });
  // Validatsiya xatosi bo'lsa — o'sha tilga o'tamiz
  var errPanel = document.querySelector('.jsite-lang-panel .has-err');
  if (errPanel) {
    var p = errPanel.closest('[data-lang-panel]');
    if (p) activate(p.dataset.langPanel);
  }

  /* ── Cover upload preview (har bir til uchun) ─── */
  function fmt(b){
    if (b < 1024) return b + ' B';
    if (b < 1024*1024) return (b/1024).toFixed(1) + ' KB';
    return (b/1024/1024).toFixed(2) + ' MB';
  }
  document.querySelectorAll('[data-cover-drop]').forEach(function(drop){
    var input = drop.querySelector('input[type=file]');
    var emptyEl = drop.querySelector('[data-empty]');
    var chosenEl = drop.querySelector('[data-chosen]');
    var nameEl = drop.querySelector('[data-name]');
    var sizeEl = drop.querySelector('[data-size]');
    var previewEl = drop.querySelector('[data-preview]');
    var changeBtn = drop.querySelector('[data-change]');

    function show(file){
      nameEl.textContent = file.name;
      sizeEl.textContent = fmt(file.size);
      emptyEl.hidden = true;
      chosenEl.hidden = false;
      var reader = new FileReader();
      reader.onload = function(e){ previewEl.src = e.target.result; previewEl.hidden = false; };
      reader.readAsDataURL(file);
    }
    function reset(){
      input.value = '';
      emptyEl.hidden = false;
      chosenEl.hidden = true;
      previewEl.hidden = true;
    }
    drop.addEventListener('click', function(e){ if (e.target === changeBtn) return; input.click(); });
    changeBtn.addEventListener('click', function(e){ e.stopPropagation(); reset(); input.click(); });
    input.addEventListener('change', function(){ if (input.files && input.files[0]) show(input.files[0]); });
    ['dragenter','dragover'].forEach(function(ev){
      drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.add('is-drag'); });
    });
    ['dragleave','drop'].forEach(function(ev){
      drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.remove('is-drag'); });
    });
    drop.addEventListener('drop', function(e){
      if (e.dataTransfer && e.dataTransfer.files.length) { input.files = e.dataTransfer.files; show(e.dataTransfer.files[0]); }
    });
  });
})();
</script>
