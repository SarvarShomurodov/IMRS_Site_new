@extends('client.journal_site.moderator._layout')

@section('title', $article->title_orig . ' — ' . __('journal.mod.panel'))

@section('panel')

@php
  $isAssign  = $article->status === 'moderator_assign';
  $isPeer    = $article->status === 'peer_review';
  $isFinal   = $article->status === 'moderator_final';

  $assignedReviewers = $article->assignedReviewers; // collection
  $reviewsByReviewer = $article->reviews->keyBy('reviewer_id');

  $totalAssigned = $assignedReviewers->count();
  $totalReviews  = $article->reviews->count();
@endphp

<a href="{{ url()->previous() }}" class="jsite-link-soft jsite-cab-back">
  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
  <span>@lang('journal.back')</span>
</a>

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">№{{ $article->id }} · {{ $article->created_at->format('Y-m-d') }}</p>
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

    {{-- File card --}}
    {{-- Plagiarism (always visible if set) --}}
    @if ($article->plagiarism_percent !== null)
      @include('client.journal_site.partials._plagiarism-card', ['percent' => $article->plagiarism_percent])
    @endif

    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.tec.file')</h2>
      <a href="{{ route('journal.moderator.article.download', $article->id) }}" class="jsite-file-card">
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

    {{-- ═══ STATE A: ASSIGN REVIEWERS ═══ --}}
    @if ($isAssign)
      <section class="jsite-cab-block jsite-tec-action-block is-review">
        <header class="jsite-tec-action-head">
          <h2 class="jsite-cab-block-title">@lang('journal.mod.assign_section')</h2>
          <p class="jsite-cab-sub">@lang('journal.mod.assign_help')</p>
        </header>

        <form method="POST" action="{{ route('journal.moderator.article.assign', $article->id) }}" id="jsiteAssignForm">
          @csrf

          <div class="jsite-mod-reviewers">
            @foreach ($availableReviewers as $r)
              <label class="jsite-mod-reviewer">
                <input type="checkbox" name="reviewer_ids[]" value="{{ $r->id }}" data-reviewer>
                <div class="jsite-mod-reviewer-card">
                  <span class="jsite-cab-avatar">{{ mb_substr($r->first_name, 0, 1) }}{{ mb_substr($r->last_name, 0, 1) }}</span>
                  <div class="jsite-mod-reviewer-info">
                    <strong>{{ $r->fullName() }}</strong>
                    @if ($r->workplace)
                      <span>{{ $r->workplace }}</span>
                    @endif
                    <small>{{ $r->reviews_given_count }} @lang('journal.mod.reviewer_articles')</small>
                  </div>
                  <span class="jsite-mod-reviewer-check">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                  </span>
                </div>
              </label>
            @endforeach
          </div>

          @error('reviewer_ids')<p class="jsite-err">{{ $message }}</p>@enderror

          <div class="jsite-mod-assign-foot">
            <p class="jsite-mod-selected-count">
              @lang('journal.mod.selected_count'):
              <strong><span id="jsiteSelectedCount">0</span> / 3</strong>
            </p>
            <button type="submit" class="jsite-btn-success" id="jsiteAssignBtn" disabled>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              <span>@lang('journal.mod.btn_assign')</span>
            </button>
          </div>
        </form>
      </section>
    @endif

    {{-- ═══ STATE B / C: PEER REVIEW STATUS ═══ --}}
    @if ($isPeer || $isFinal || $article->status === 'ready_to_publish' || $article->status === 'published' || $article->status === 'moderator_rejected')
      <section class="jsite-cab-block">
        <header class="jsite-cab-block-head">
          <h2 class="jsite-cab-block-title">@lang('journal.mod.peer_section')</h2>
          @if ($isPeer)
            @if ($totalReviews >= $totalAssigned && $totalAssigned > 0)
              <span class="jsite-status-badge is-success">
                <span class="jsite-status-text">@lang('journal.mod.all_done_can_decide')</span>
              </span>
            @else
              <span class="jsite-status-badge is-purple">
                <span class="jsite-status-text">{{ $totalReviews }} / {{ $totalAssigned }}</span>
              </span>
            @endif
          @endif
        </header>

        <ul class="jsite-mod-review-list">
          @foreach ($assignedReviewers as $rev)
            @php $review = $reviewsByReviewer->get($rev->id); @endphp
            <li class="jsite-mod-review-item @if($review) is-completed @else is-pending @endif">
              <div class="jsite-mod-review-head">
                <span class="jsite-cab-avatar">{{ mb_substr($rev->first_name, 0, 1) }}{{ mb_substr($rev->last_name, 0, 1) }}</span>
                <div class="jsite-mod-review-meta">
                  <strong>{{ $rev->fullName() }}</strong>
                  @if ($rev->workplace)
                    <span>{{ $rev->workplace }}</span>
                  @endif
                </div>
                <span class="jsite-status-badge @if($review) is-success @else is-warn @endif">
                  <span class="jsite-status-text">
                    @if($review)
                      @lang('journal.mod.reviewer_status_completed')
                    @else
                      @lang('journal.mod.reviewer_status_pending')
                    @endif
                  </span>
                </span>
              </div>

              @if ($review)
                @php $avg = $review->averageScore(); @endphp
                <div class="jsite-mod-review-body">
                  <div class="jsite-mod-review-decision">
                    <span class="jsite-mod-review-lbl">@lang('journal.mod.reviewer_decision'):</span>
                    @switch($review->decision)
                      @case('accept_no_review')
                        <span class="jsite-status-badge is-success"><span class="jsite-status-text">Qabul (qaytadan ko'rmasdan)</span></span>
                        @break
                      @case('accept_with_review')
                        <span class="jsite-status-badge is-warn"><span class="jsite-status-text">Qabul (qayta ko'rib)</span></span>
                        @break
                      @case('reject')
                        <span class="jsite-status-badge is-danger"><span class="jsite-status-text">Rad etish</span></span>
                        @break
                    @endswitch

                    @if ($avg !== null)
                      <span class="jsite-mod-review-avg">
                        @lang('journal.mod.avg_score'): <strong>{{ $avg }}</strong> / 5
                      </span>
                    @endif
                  </div>

                  {{-- 7 mezon scores --}}
                  <div class="jsite-mod-scores">
                    @foreach ([
                      'score_research_name'    => 'Tadqiqotning nomi',
                      'score_topic_relevance'  => 'Mavzuning dolzarbligi',
                      'score_problem_analysis' => 'Muammoning tahlili',
                      'score_problem_solutions'=> 'Hal qilish yo\'llari',
                      'score_recommendations'  => 'Tavsiyalarning asoslanganligi',
                      'score_originality'      => 'Originallik',
                      'score_clarity'          => 'Aniq va ravon bayon',
                    ] as $field => $label)
                      @if ($review->{$field})
                        <div class="jsite-mod-score-row">
                          <span class="jsite-mod-score-lbl">{{ $label }}</span>
                          <span class="jsite-mod-score-bar">
                            @for ($i = 1; $i <= 5; $i++)
                              <span @class(['is-on' => $i <= $review->{$field}])></span>
                            @endfor
                          </span>
                          <span class="jsite-mod-score-val">{{ $review->{$field} }}/5</span>
                        </div>
                      @endif
                    @endforeach
                  </div>

                  @if ($review->comment)
                    <div class="jsite-mod-review-comment">
                      <strong>@lang('journal.mod.review_comment'):</strong>
                      <p>{{ $review->comment }}</p>
                    </div>
                  @endif
                  @if ($review->rejection_reason)
                    <div class="jsite-mod-review-comment is-danger">
                      <strong>@lang('journal.mod.review_rejection'):</strong>
                      <p>{{ $review->rejection_reason }}</p>
                    </div>
                  @endif
                </div>
              @else
                <p class="jsite-mod-review-pending">@lang('journal.mod.no_review_yet')</p>
              @endif
            </li>
          @endforeach
        </ul>
      </section>
    @endif

    {{-- ═══ Reassign reviewers (peer_review yoki moderator_final) ═══ --}}
    @if ($isPeer || $isFinal)
      <section class="jsite-cab-block jsite-tec-action-block is-review">
        <header class="jsite-tec-action-head">
          <h2 class="jsite-cab-block-title">@lang('journal.mod.reassign_section')</h2>
          <p class="jsite-cab-sub">@lang('journal.mod.reassign_help')</p>
        </header>

        <button type="button" class="jsite-btn-warn" data-open-modal="reassignModal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
          <span>@lang('journal.mod.btn_reassign')</span>
        </button>

        <div class="jsite-modal" id="reassignModal" hidden>
          <div class="jsite-modal-backdrop" data-close-modal></div>
          <div class="jsite-modal-card jsite-modal-card-lg">
            <header class="jsite-modal-head">
              <h3>@lang('journal.mod.reassign_section')</h3>
              <button type="button" class="jsite-modal-close" data-close-modal aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </button>
            </header>
            <form method="POST" action="{{ route('journal.moderator.article.reassign', $article->id) }}" class="jsite-modal-body" id="jsiteReassignForm">
              @csrf
              <p class="jsite-cab-sub" style="margin-bottom:1rem;">@lang('journal.mod.reassign_help')</p>

              @php $currentRevIds = $assignedReviewers->pluck('id')->all(); @endphp
              <div class="jsite-mod-reviewers">
                @foreach ($availableReviewers as $r)
                  <label class="jsite-mod-reviewer">
                    <input type="checkbox" name="reviewer_ids[]" value="{{ $r->id }}" data-reassign-reviewer
                           @if(in_array($r->id, $currentRevIds, true)) disabled title="{{ __('journal.mod.previous_reviewers') }}" @endif>
                    <div class="jsite-mod-reviewer-card">
                      <span class="jsite-cab-avatar">{{ mb_substr($r->first_name, 0, 1) }}{{ mb_substr($r->last_name, 0, 1) }}</span>
                      <div class="jsite-mod-reviewer-info">
                        <strong>{{ $r->fullName() }}</strong>
                        @if ($r->workplace)
                          <span>{{ $r->workplace }}</span>
                        @endif
                        <small>
                          @if(in_array($r->id, $currentRevIds, true))
                            @lang('journal.mod.previous_reviewers')
                          @else
                            {{ $r->reviews_given_count }} @lang('journal.mod.reviewer_articles')
                          @endif
                        </small>
                      </div>
                      <span class="jsite-mod-reviewer-check">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                      </span>
                    </div>
                  </label>
                @endforeach
              </div>

              <footer class="jsite-modal-foot">
                <p class="jsite-mod-selected-count">
                  @lang('journal.mod.selected_count'):
                  <strong><span id="jsiteReassignSelectedCount">0</span> / 3</strong>
                </p>
                <button type="button" class="jsite-btn-ghost" data-close-modal>@lang('journal.tec.btn_cancel')</button>
                <button type="submit" class="jsite-btn-warn" id="jsiteReassignBtn" disabled>
                  <span>@lang('journal.mod.btn_reassign')</span>
                </button>
              </footer>
            </form>
          </div>
        </div>
      </section>
    @endif

    {{-- ═══ STATE D: FINAL DECISION ═══ --}}
    @if ($isFinal)
      <section class="jsite-cab-block jsite-tec-action-block is-publish">
        <header class="jsite-tec-action-head">
          <h2 class="jsite-cab-block-title">@lang('journal.mod.final_section')</h2>
          <p class="jsite-cab-sub">@lang('journal.mod.final_help')</p>
        </header>

        <form method="POST" action="{{ route('journal.moderator.article.final_approve', $article->id) }}" class="jsite-auth-form jsite-cab-form">
          @csrf

          <div class="jsite-row-2">
            <div class="jsite-field @error('category') has-err @enderror">
              <label for="category">@lang('journal.mod.category') <span class="req">*</span></label>
              <div class="jsite-input">
                <select name="category" id="category" required>
                  <option value="">— @lang('journal.mod.category_select') —</option>
                  @foreach ($categories as $c)
                    <option value="{{ $c }}" @selected(old('category', $article->category) === $c)>
                      {{ __('journal.cat.'.$c) }}
                    </option>
                  @endforeach
                </select>
              </div>
              @error('category')<p class="jsite-err">{{ $message }}</p>@enderror
            </div>

            <div class="jsite-field @error('tags') has-err @enderror">
              <label for="tags">@lang('journal.mod.tags')</label>
              <div class="jsite-input">
                <input type="text" id="tags" name="tags" value="{{ old('tags', is_array($article->tags) ? implode(', ', $article->tags) : '') }}" placeholder="@lang('journal.mod.tags_ph')">
              </div>
              <p class="jsite-field-help">@lang('journal.mod.tags_help')</p>
              @error('tags')<p class="jsite-err">{{ $message }}</p>@enderror
            </div>
          </div>

          <div class="jsite-mod-final-actions">
            <button type="submit" class="jsite-btn-success">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              <span>@lang('journal.mod.btn_final_approve')</span>
            </button>
            <button type="button" class="jsite-btn-danger" data-open-modal="finalRejectModal">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              <span>@lang('journal.mod.btn_final_reject')</span>
            </button>
          </div>
        </form>

        {{-- Reject modal --}}
        <div class="jsite-modal" id="finalRejectModal" hidden>
          <div class="jsite-modal-backdrop" data-close-modal></div>
          <div class="jsite-modal-card">
            <header class="jsite-modal-head">
              <h3>@lang('journal.mod.final_reject_modal_title')</h3>
              <button type="button" class="jsite-modal-close" data-close-modal>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </button>
            </header>
            <form method="POST" action="{{ route('journal.moderator.article.final_reject', $article->id) }}" class="jsite-modal-body">
              @csrf
              <p class="jsite-cab-sub" style="margin-bottom:1rem;">@lang('journal.mod.final_reject_modal_sub')</p>
              <div class="jsite-field">
                <label for="final_reject_reason">@lang('journal.mod.final_reject_modal_title') <span class="req">*</span></label>
                <textarea name="reason" id="final_reject_reason" class="jsite-textarea" rows="5" minlength="10" maxlength="1500" required></textarea>
              </div>
              <footer class="jsite-modal-foot">
                <button type="button" class="jsite-btn-ghost" data-close-modal>@lang('journal.tec.btn_cancel')</button>
                <button type="submit" class="jsite-btn-danger">@lang('journal.tec.btn_confirm_reject')</button>
              </footer>
            </form>
          </div>
        </div>
      </section>
    @endif

    {{-- Already-rejected/published category info --}}
    @if (in_array($article->status, ['ready_to_publish','published']) && $article->category)
      <section class="jsite-cab-block">
        <h2 class="jsite-cab-block-title">@lang('journal.mod.final_section')</h2>
        <dl class="jsite-cab-meta">
          <div>
            <dt>@lang('journal.mod.category')</dt>
            <dd><span class="jsite-cab-cat-pill">{{ __('journal.cat.'.$article->category) }}</span></dd>
          </div>
          @if (!empty($article->tags))
            <div>
              <dt>@lang('journal.mod.tags')</dt>
              <dd>
                @foreach ($article->tags as $tag)
                  <span class="jsite-cab-cat-pill">#{{ $tag }}</span>
                @endforeach
              </dd>
            </div>
          @endif
        </dl>
      </section>
    @endif

    @if ($article->status === 'moderator_rejected' && $article->rejection_reason)
      <div class="jsite-alert jsite-alert-err jsite-alert-block">
        <strong>@lang('journal.cab.rejection_reason')</strong>
        <p>{{ $article->rejection_reason }}</p>
      </div>
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
  /* Modal toggle */
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

  /* Reviewer assignment: limit 3 */
  function bindReviewerLimit(selector, counterId, btnId) {
    var checkboxes = document.querySelectorAll(selector);
    var counter = document.getElementById(counterId);
    var btn = document.getElementById(btnId);
    if (!checkboxes.length || !counter || !btn) return;

    function update() {
      // Foydalanuvchi tanlamoqchi bo'lgan (disabled bo'lmagan) checkbox'larni hisoblaymiz
      var selectable = Array.from(checkboxes).filter(function(cb){ return !cb.disabled || cb.checked; });
      var n = selectable.filter(function(cb){ return cb.checked; }).length;
      counter.textContent = n;
      btn.disabled = n < 1;

      checkboxes.forEach(function(cb){
        // Maqola hozirgi taqrizchilari (disabled by server) o'zgartirilmaydi.
        if (cb.dataset._origDisabled === '1') return;
        cb.disabled = !cb.checked && n >= 3;
      });
    }

    // Server tomonida disabled bo'lganlarni belgilab olamiz
    checkboxes.forEach(function(cb){
      if (cb.disabled) cb.dataset._origDisabled = '1';
      cb.addEventListener('change', update);
    });
    update();
  }

  bindReviewerLimit('[data-reviewer]',          'jsiteSelectedCount',         'jsiteAssignBtn');
  bindReviewerLimit('[data-reassign-reviewer]', 'jsiteReassignSelectedCount', 'jsiteReassignBtn');
})();
</script>
@endpush
