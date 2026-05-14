@extends('client.journal_site.technic._layout')

@section('title', $article->title_orig . ' — ' . __('journal.tec.panel'))

@section('panel')

@php
  $isReview  = $article->status === 'technical_review';
  $isPublish = $article->status === 'ready_to_publish';
@endphp

<a href="{{ url()->previous() }}" class="jsite-link-soft jsite-cab-back">
  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
  <span>@lang('journal.back')</span>
</a>

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">№{{ $article->id }} · {{ $article->created_at->format('Y-m-d H:i') }}</p>
  <h1 class="jsite-cab-title">{{ $article->title_orig }}</h1>
  <div class="jsite-cab-head-status">
    @include('client.journal_site.components.status-badge', ['status' => $article->status])
  </div>
</header>

<div class="jsite-cab-detail-grid">

  {{-- ── Main column ── --}}
  <div class="jsite-cab-detail-main">

    {{-- Author info --}}
    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.tec.submitted_by')</h2>
      <div class="jsite-tec-author">
        <span class="jsite-cab-avatar" style="width:48px;height:48px;font-size:1rem;">
          {{ mb_substr($article->author->first_name, 0, 1) }}{{ mb_substr($article->author->last_name, 0, 1) }}
        </span>
        <div class="jsite-tec-author-info">
          <strong>{{ $article->author->fullName() }}</strong>
          @if ($article->author->workplace)
            <span>{{ $article->author->workplace }}</span>
          @endif
          <div class="jsite-tec-author-contacts">
            <a href="mailto:{{ $article->author->email }}" class="jsite-link-soft">{{ $article->author->email }}</a>
            @if ($article->author->phone)
              <span class="jsite-cab-dot">·</span>
              <span>{{ $article->author->phone }}</span>
            @endif
          </div>
        </div>
      </div>
    </section>

    {{-- Plagiarism (always visible if set) --}}
    @if ($article->plagiarism_percent !== null)
      @include('client.journal_site.partials._plagiarism-card', ['percent' => $article->plagiarism_percent])
    @endif

    {{-- File card --}}
    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.tec.file')</h2>
      <a href="{{ route('journal.technic.article.download', $article->id) }}" class="jsite-file-card">
        <span class="jsite-file-card-ico">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </span>
        <div class="jsite-file-card-info">
          <strong>{{ $article->file_original_name }}</strong>
          @if ($article->file_size)
            <span>{{ number_format($article->file_size / 1024 / 1024, 2) }} MB · @lang('journal.tec.download')</span>
          @endif
        </div>
        <span class="jsite-file-card-arrow">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        </span>
      </a>
    </section>

    {{-- ═══ ACTION SECTIONS ═══ --}}

    {{-- A) Review (technical_review) — approve / revision / reject --}}
    @if ($isReview)
      <section class="jsite-cab-block jsite-tec-action-block is-review">
        <header class="jsite-tec-action-head">
          <h2 class="jsite-cab-block-title">@lang('journal.tec.review_section')</h2>
          <p class="jsite-cab-sub">@lang('journal.tec.review_help')</p>
        </header>

        {{-- Approve form with plagiarism input --}}
        <form method="POST" action="{{ route('journal.technic.article.approve', $article->id) }}" class="jsite-tec-approve-form">
          @csrf
          <div class="jsite-tec-plagiarism-field">
            <label for="plagiarism_percent">
              @lang('journal.tec.plagiarism_label')
              <span class="req">*</span>
            </label>
            <p class="jsite-field-help">@lang('journal.tec.plagiarism_help')</p>
            <div class="jsite-tec-plag-input">
              <input type="number" name="plagiarism_percent" id="plagiarism_percent"
                     min="0" max="100" step="1"
                     placeholder="{{ __('journal.tec.plagiarism_ph') }}"
                     value="{{ old('plagiarism_percent', $article->plagiarism_percent) }}"
                     autocomplete="off" required>
              <span class="jsite-tec-plag-suffix">%</span>
            </div>
            @error('plagiarism_percent')
              <span class="jsite-field-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="jsite-tec-action-buttons">
            <button type="submit" class="jsite-btn-success">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              <span>@lang('journal.tec.btn_approve')</span>
            </button>

            <button type="button" class="jsite-btn-warn" data-open-modal="revisionModal">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
              <span>@lang('journal.tec.btn_revision')</span>
            </button>

            <button type="button" class="jsite-btn-danger" data-open-modal="rejectModal">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              <span>@lang('journal.tec.btn_reject')</span>
            </button>
          </div>
        </form>

        {{-- Reject modal --}}
        <div class="jsite-modal" id="rejectModal" hidden>
          <div class="jsite-modal-backdrop" data-close-modal></div>
          <div class="jsite-modal-card">
            <header class="jsite-modal-head">
              <h3>@lang('journal.tec.reject_modal_title')</h3>
              <button type="button" class="jsite-modal-close" data-close-modal aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </button>
            </header>
            <form method="POST" action="{{ route('journal.technic.article.reject', $article->id) }}" class="jsite-modal-body">
              @csrf
              <p class="jsite-cab-sub" style="margin-bottom:1rem;">@lang('journal.tec.reject_modal_sub')</p>
              <div class="jsite-field">
                <label for="reject_plagiarism">@lang('journal.tec.plagiarism_label')</label>
                <div class="jsite-tec-plag-input">
                  <input type="number" name="plagiarism_percent" id="reject_plagiarism"
                         class="jsite-input" min="0" max="100" step="1"
                         placeholder="{{ __('journal.tec.plagiarism_ph') }}"
                         value="{{ $article->plagiarism_percent }}">
                  <span class="jsite-tec-plag-suffix">%</span>
                </div>
              </div>
              <div class="jsite-field">
                <label for="reject_reason">@lang('journal.tec.reject_modal_title') <span class="req">*</span></label>
                <textarea name="reason" id="reject_reason" class="jsite-textarea" rows="5" minlength="10" maxlength="1500" placeholder="@lang('journal.tec.reject_reason_ph')" required></textarea>
              </div>
              <footer class="jsite-modal-foot">
                <button type="button" class="jsite-btn-ghost" data-close-modal>@lang('journal.tec.btn_cancel')</button>
                <button type="submit" class="jsite-btn-danger">@lang('journal.tec.btn_confirm_reject')</button>
              </footer>
            </form>
          </div>
        </div>

        {{-- Revision modal --}}
        <div class="jsite-modal" id="revisionModal" hidden>
          <div class="jsite-modal-backdrop" data-close-modal></div>
          <div class="jsite-modal-card">
            <header class="jsite-modal-head">
              <h3>@lang('journal.tec.revision_modal_title')</h3>
              <button type="button" class="jsite-modal-close" data-close-modal aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </button>
            </header>
            <form method="POST" action="{{ route('journal.technic.article.revision', $article->id) }}" class="jsite-modal-body">
              @csrf
              <p class="jsite-cab-sub" style="margin-bottom:1rem;">@lang('journal.tec.revision_modal_sub')</p>
              <div class="jsite-field">
                <label for="revision_plagiarism">@lang('journal.tec.plagiarism_label')</label>
                <div class="jsite-tec-plag-input">
                  <input type="number" name="plagiarism_percent" id="revision_plagiarism"
                         class="jsite-input" min="0" max="100" step="1"
                         placeholder="{{ __('journal.tec.plagiarism_ph') }}"
                         value="{{ $article->plagiarism_percent }}">
                  <span class="jsite-tec-plag-suffix">%</span>
                </div>
              </div>
              <div class="jsite-field">
                <label for="revision_reason">@lang('journal.tec.revision_modal_title') <span class="req">*</span></label>
                <textarea name="reason" id="revision_reason" class="jsite-textarea" rows="5" minlength="10" maxlength="1500" placeholder="@lang('journal.tec.revision_reason_ph')" required></textarea>
              </div>
              <footer class="jsite-modal-foot">
                <button type="button" class="jsite-btn-ghost" data-close-modal>@lang('journal.tec.btn_cancel')</button>
                <button type="submit" class="jsite-btn-warn">@lang('journal.tec.btn_confirm_revision')</button>
              </footer>
            </form>
          </div>
        </div>
      </section>
    @endif

    {{-- B) Publish (ready_to_publish) — fill publish form --}}
    @if ($isPublish)
      <section class="jsite-cab-block jsite-tec-action-block is-publish">
        <header class="jsite-tec-action-head">
          <h2 class="jsite-cab-block-title">@lang('journal.tec.publish_section')</h2>
          <p class="jsite-cab-sub">@lang('journal.tec.publish_help')</p>
        </header>

        <form method="POST" action="{{ route('journal.technic.article.publish', $article->id) }}" enctype="multipart/form-data" class="jsite-auth-form jsite-cab-form">
          @csrf

          {{-- Read-only: category + tags (Moderator-set) --}}
          <div class="jsite-row-2">
            <div class="jsite-field">
              <label>@lang('journal.tec.category') <small style="font-weight:400;color:var(--t3);text-transform:none;letter-spacing:0;">— @lang('journal.tec.tags_set_by_mod')</small></label>
              <div class="jsite-readonly-pill">
                {{ $article->category ?: '—' }}
              </div>
            </div>
            <div class="jsite-field">
              <label>@lang('journal.tec.tags') <small style="font-weight:400;color:var(--t3);text-transform:none;letter-spacing:0;">— @lang('journal.tec.tags_set_by_mod')</small></label>
              <div class="jsite-readonly-tags">
                @forelse (($article->tags ?: []) as $tag)
                  <span class="jsite-cab-cat-pill">#{{ $tag }}</span>
                @empty
                  <span style="color:var(--t3);">—</span>
                @endforelse
              </div>
            </div>
          </div>

          {{-- Title for publication --}}
          <div class="jsite-field @error('title_publish') has-err @enderror">
            <label for="title_publish">@lang('journal.tec.publish_title') <span class="req">*</span></label>
            <div class="jsite-input">
              <input type="text" id="title_publish" name="title_publish" value="{{ old('title_publish', $article->title_publish ?: $article->title_orig) }}" placeholder="@lang('journal.tec.publish_title_ph')" required>
            </div>
            @error('title_publish')<p class="jsite-err">{{ $message }}</p>@enderror
          </div>

          {{-- Description --}}
          <div class="jsite-field @error('description') has-err @enderror">
            <label for="description">@lang('journal.tec.description') <span class="req">*</span></label>
            <textarea name="description" id="description" class="jsite-textarea" rows="3" minlength="30" maxlength="500" placeholder="@lang('journal.tec.description_ph')" required>{{ old('description', $article->description) }}</textarea>
            <p class="jsite-field-help">@lang('journal.tec.description_help')</p>
            @error('description')<p class="jsite-err">{{ $message }}</p>@enderror
          </div>

          {{-- Publish date + Cover --}}
          <div class="jsite-row-2">
            <div class="jsite-field @error('publish_date') has-err @enderror">
              <label for="publish_date">@lang('journal.tec.publish_date') <span class="req">*</span></label>
              <div class="jsite-input">
                <input type="date" id="publish_date" name="publish_date" value="{{ old('publish_date', optional($article->publish_date)->format('Y-m-d') ?: now()->format('Y-m-d')) }}" required>
              </div>
              @error('publish_date')<p class="jsite-err">{{ $message }}</p>@enderror
            </div>

            <div class="jsite-field @error('cover') has-err @enderror">
              <label for="cover">@lang('journal.tec.cover') <span class="req">*</span></label>

              <div class="jsite-file-drop" id="jsiteCoverDrop">
                <input type="file" id="cover" name="cover" accept="image/jpeg,image/png" required hidden>
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

              @error('cover')<p class="jsite-err">{{ $message }}</p>@enderror
            </div>
          </div>

          <div class="jsite-cab-form-actions">
            <button type="submit" class="jsite-btn-success">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span>@lang('journal.tec.btn_publish')</span>
            </button>
          </div>
        </form>
      </section>
    @endif

    {{-- C) Already-rejected: show rejection reason --}}
    @if (in_array($article->status, ['technic_rejected','moderator_rejected']) && $article->rejection_reason)
      <div class="jsite-alert jsite-alert-err jsite-alert-block">
        <strong>@lang('journal.cab.rejection_reason')</strong>
        <p>{{ $article->rejection_reason }}</p>
      </div>
    @endif

    {{-- D) Already published: show publish info --}}
    @if ($article->isPublished())
      <section class="jsite-cab-block">
        <h2 class="jsite-cab-block-title">@lang('journal.tec.publish_section')</h2>
        <dl class="jsite-cab-meta">
          <div>
            <dt>@lang('journal.tec.publish_title')</dt>
            <dd>{{ $article->title_publish }}</dd>
          </div>
          <div>
            <dt>@lang('journal.tec.publish_date')</dt>
            <dd>{{ optional($article->publish_date)->format('Y-m-d') }}</dd>
          </div>
          @if ($article->cover)
            <div>
              <dt>@lang('journal.tec.cover')</dt>
              <dd><img src="{{ asset('storage/'.$article->cover) }}" alt="" style="max-width:240px;border-radius:6px;"></dd>
            </div>
          @endif
        </dl>
      </section>
    @endif

  </div>

  {{-- ── Side: history timeline ── --}}
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
              @if ($h->user)
                <small>{{ $h->user->shortName() }}</small>
              @endif
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

@push('scripts')
<script>
(function(){
  /* ── Modal toggle ────────────────────────────── */
  document.querySelectorAll('[data-open-modal]').forEach(function(btn){
    btn.addEventListener('click', function(){
      var m = document.getElementById(btn.dataset.openModal);
      if (m) { m.hidden = false; document.body.style.overflow = 'hidden'; }
    });
  });
  document.querySelectorAll('[data-close-modal]').forEach(function(el){
    el.addEventListener('click', function(){
      var m = el.closest('.jsite-modal');
      if (m) { m.hidden = true; document.body.style.overflow = ''; }
    });
  });
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') {
      document.querySelectorAll('.jsite-modal:not([hidden])').forEach(function(m){
        m.hidden = true;
      });
      document.body.style.overflow = '';
    }
  });

  /* ── Cover image upload preview ──────────────── */
  var drop = document.getElementById('jsiteCoverDrop');
  if (!drop) return;
  var input = drop.querySelector('input[type=file]');
  var emptyEl = drop.querySelector('[data-empty]');
  var chosenEl = drop.querySelector('[data-chosen]');
  var nameEl = drop.querySelector('[data-name]');
  var sizeEl = drop.querySelector('[data-size]');
  var previewEl = drop.querySelector('[data-preview]');
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
    var reader = new FileReader();
    reader.onload = function(e){
      previewEl.src = e.target.result;
      previewEl.hidden = false;
    };
    reader.readAsDataURL(file);
  }
  function reset() {
    input.value = '';
    emptyEl.hidden = false;
    chosenEl.hidden = true;
    previewEl.hidden = true;
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
    drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.add('is-drag'); });
  });
  ['dragleave','drop'].forEach(function(ev){
    drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.remove('is-drag'); });
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
