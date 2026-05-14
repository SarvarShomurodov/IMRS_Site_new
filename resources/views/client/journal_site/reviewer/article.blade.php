@extends('client.journal_site.reviewer._layout')

@section('title', $article->title_orig . ' — ' . __('journal.rev.panel'))

@section('panel')

@php
  $isPending = $pivotStatus === 'pending' && !$myReview;
  $isCompleted = (bool) $myReview;

  $criteria = [
    'score_research_name'     => __('journal.rev.crit_1'),
    'score_topic_relevance'   => __('journal.rev.crit_2'),
    'score_problem_analysis'  => __('journal.rev.crit_3'),
    'score_problem_solutions' => __('journal.rev.crit_4'),
    'score_recommendations'   => __('journal.rev.crit_5'),
    'score_originality'       => __('journal.rev.crit_6'),
    'score_clarity'           => __('journal.rev.crit_7'),
  ];
@endphp

<a href="{{ url()->previous() }}" class="jsite-link-soft jsite-cab-back">
  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
  <span>@lang('journal.back')</span>
</a>

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">№{{ $article->id }} · {{ $article->updated_at->format('Y-m-d') }}</p>
  <h1 class="jsite-cab-title">{{ $article->title_orig }}</h1>
  <div class="jsite-cab-head-status">
    @if ($isCompleted)
      <span class="jsite-status-badge is-success">
        <span class="jsite-status-text">@lang('journal.mod.reviewer_status_completed')</span>
      </span>
    @else
      <span class="jsite-status-badge is-warn">
        <span class="jsite-status-text">@lang('journal.mod.reviewer_status_pending')</span>
      </span>
    @endif
  </div>
</header>

{{-- Anonymity notice --}}
<div class="jsite-alert jsite-alert-ok jsite-alert-block">
  <strong>🛡 @lang('journal.rev.anonymous_notice')</strong>
</div>

<div class="jsite-cab-detail-grid">
  <div class="jsite-cab-detail-main">

    {{-- Plagiarism (always visible if set) --}}
    @if ($article->plagiarism_percent !== null)
      @include('client.journal_site.partials._plagiarism-card', ['percent' => $article->plagiarism_percent])
    @endif

    {{-- File card --}}
    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.tec.file')</h2>
      <a href="{{ route('journal.reviewer.article.download', $article->id) }}" class="jsite-file-card">
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

    {{-- ═══ STATE A: REVIEW FORM (pending) ═══ --}}
    @if ($isPending)
      <section class="jsite-cab-block jsite-tec-action-block is-publish">
        <header class="jsite-tec-action-head">
          <h2 class="jsite-cab-block-title">@lang('journal.rev.review_form_title')</h2>
          <p class="jsite-cab-sub">@lang('journal.rev.review_form_sub')</p>
        </header>

        <form method="POST" action="{{ route('journal.reviewer.article.submit', $article->id) }}" id="jsiteReviewForm">
          @csrf

          {{-- 7 mezon table (rasmdagi shakl) --}}
          <h3 class="jsite-rev-section-title">@lang('journal.rev.criteria_title')</h3>
          <p class="jsite-rev-legend">@lang('journal.rev.score_legend')</p>

          <table class="jsite-rev-table">
            <thead>
              <tr>
                <th class="jsite-rev-crit-col">#</th>
                <th>@lang('journal.rev.criteria_title')</th>
                <th class="jsite-rev-score-col">5</th>
                <th class="jsite-rev-score-col">4</th>
                <th class="jsite-rev-score-col">3</th>
                <th class="jsite-rev-score-col">2</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($criteria as $field => $label)
                <tr @class(['has-err' => $errors->has($field)])>
                  <td class="jsite-rev-num">{{ $loop->iteration }}</td>
                  <td class="jsite-rev-label">{{ $label }}</td>
                  @foreach ([5, 4, 3, 2] as $score)
                    <td class="jsite-rev-cell">
                      <label class="jsite-rev-radio">
                        <input type="radio" name="{{ $field }}" value="{{ $score }}" @checked(old($field) == $score) required>
                        <span class="jsite-rev-radio-mark">{{ $score }}</span>
                      </label>
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>

          @foreach ($criteria as $field => $label)
            @error($field)<p class="jsite-err">{{ $label }}: {{ $message }}</p>@enderror
          @endforeach

          {{-- Decision --}}
          <h3 class="jsite-rev-section-title">@lang('journal.rev.decision_section')</h3>
          <p class="jsite-cab-sub">@lang('journal.rev.decision_help')</p>

          <div class="jsite-rev-decisions">
            <label class="jsite-rev-decision">
              <input type="radio" name="decision" value="accept_no_review" @checked(old('decision') === 'accept_no_review') required>
              <div class="jsite-rev-decision-card is-success">
                <strong>@lang('journal.rev.decision_accept_no')</strong>
                <span>@lang('journal.rev.decision_help_no')</span>
              </div>
            </label>
            <label class="jsite-rev-decision">
              <input type="radio" name="decision" value="accept_with_review" @checked(old('decision') === 'accept_with_review') required>
              <div class="jsite-rev-decision-card is-warn">
                <strong>@lang('journal.rev.decision_accept_with')</strong>
                <span>@lang('journal.rev.decision_help_with')</span>
              </div>
            </label>
            <label class="jsite-rev-decision">
              <input type="radio" name="decision" value="reject" @checked(old('decision') === 'reject') required>
              <div class="jsite-rev-decision-card is-danger">
                <strong>@lang('journal.rev.decision_reject')</strong>
                <span>@lang('journal.rev.decision_help_reject')</span>
              </div>
            </label>
          </div>
          @error('decision')<p class="jsite-err">{{ $message }}</p>@enderror

          {{-- Conditional textarea fields --}}
          <div class="jsite-field" data-show-when="comment">
            <label for="comment">@lang('journal.rev.comment_label')</label>
            <textarea name="comment" id="comment" class="jsite-textarea" rows="4" maxlength="3000" placeholder="@lang('journal.rev.comment_ph')">{{ old('comment') }}</textarea>
            <p class="jsite-field-help">@lang('journal.rev.comment_help')</p>
          </div>

          <div class="jsite-field" data-show-when="rejection" hidden>
            <label for="rejection_reason">@lang('journal.rev.review_rejection') <span class="req">*</span></label>
            <textarea name="rejection_reason" id="rejection_reason" class="jsite-textarea" rows="4" maxlength="3000" placeholder="@lang('journal.rev.review_rejection_ph')">{{ old('rejection_reason') }}</textarea>
          </div>

          <div class="jsite-cab-form-actions">
            <button type="submit" class="jsite-btn-success" data-confirm="@lang('journal.rev.submit_confirm')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              <span>@lang('journal.rev.btn_submit')</span>
            </button>
          </div>

        </form>
      </section>
    @endif

    {{-- ═══ STATE B: ALREADY REVIEWED ═══ --}}
    @if ($isCompleted)
      <section class="jsite-cab-block">
        <h2 class="jsite-cab-block-title">@lang('journal.rev.my_review_title')</h2>

        <div class="jsite-mod-review-decision" style="margin-bottom: 1.5rem;">
          <span class="jsite-mod-review-lbl">@lang('journal.rev.my_decision'):</span>
          @switch($myReview->decision)
            @case('accept_no_review')
              <span class="jsite-status-badge is-success"><span class="jsite-status-text">@lang('journal.rev.decision_accept_no')</span></span>
              @break
            @case('accept_with_review')
              <span class="jsite-status-badge is-warn"><span class="jsite-status-text">@lang('journal.rev.decision_accept_with')</span></span>
              @break
            @case('reject')
              <span class="jsite-status-badge is-danger"><span class="jsite-status-text">@lang('journal.rev.decision_reject')</span></span>
              @break
          @endswitch

          @if ($myReview->averageScore() !== null)
            <span class="jsite-mod-review-avg">
              @lang('journal.rev.my_avg_score'): <strong>{{ $myReview->averageScore() }}</strong> / 5
            </span>
          @endif
        </div>

        <div class="jsite-mod-scores">
          @foreach ($criteria as $field => $label)
            @if ($myReview->{$field})
              <div class="jsite-mod-score-row">
                <span class="jsite-mod-score-lbl">{{ $label }}</span>
                <span class="jsite-mod-score-bar">
                  @for ($i = 1; $i <= 5; $i++)
                    <span @class(['is-on' => $i <= $myReview->{$field}])></span>
                  @endfor
                </span>
                <span class="jsite-mod-score-val">{{ $myReview->{$field} }}/5</span>
              </div>
            @endif
          @endforeach
        </div>

        @if ($myReview->comment)
          <div class="jsite-mod-review-comment" style="margin-top:1rem;">
            <strong>@lang('journal.mod.review_comment'):</strong>
            <p>{{ $myReview->comment }}</p>
          </div>
        @endif
        @if ($myReview->rejection_reason)
          <div class="jsite-mod-review-comment is-danger" style="margin-top:1rem;">
            <strong>@lang('journal.mod.review_rejection'):</strong>
            <p>{{ $myReview->rejection_reason }}</p>
          </div>
        @endif

        <p class="jsite-cab-sub" style="margin-top:1.5rem; font-style:italic;">
          {{ $myReview->created_at->format('Y-m-d H:i') }} — @lang('journal.rev.action_review_completed')
        </p>
      </section>
    @endif

  </div>

  {{-- Side: minimal info --}}
  <aside class="jsite-cab-detail-side">
    <section class="jsite-cab-block">
      <h2 class="jsite-cab-block-title">@lang('journal.cab.article_detail')</h2>
      <dl class="jsite-cab-meta">
        <div>
          <dt>№</dt>
          <dd>{{ $article->id }}</dd>
        </div>
        <div>
          <dt>@lang('journal.cab.submitted_at')</dt>
          <dd>{{ $article->created_at->format('Y-m-d') }}</dd>
        </div>
        <div>
          <dt>@lang('journal.cab.status')</dt>
          <dd>@include('client.journal_site.components.status-badge', ['status' => $article->status])</dd>
        </div>
      </dl>
    </section>
  </aside>

</div>

@endsection

@push('scripts')
<script>
(function(){
  /* Decision change → toggle objections/rejection textarea */
  var form = document.getElementById('jsiteReviewForm');
  if (!form) return;

  var rejectionField = form.querySelector('[data-show-when="rejection"]');
  var commentField = form.querySelector('[data-show-when="comment"]');
  var commentLabel = commentField ? commentField.querySelector('label') : null;
  var commentTextarea = commentField ? commentField.querySelector('textarea') : null;

  var decisionInputs = form.querySelectorAll('input[name="decision"]');
  decisionInputs.forEach(function(i){
    i.addEventListener('change', function(){
      var v = i.value;
      if (rejectionField) {
        rejectionField.hidden = v !== 'reject';
        var rejInput = rejectionField.querySelector('textarea');
        if (rejInput) rejInput.required = (v === 'reject');
      }
      if (commentLabel && commentTextarea) {
        if (v === 'accept_with_review') {
          commentLabel.innerHTML = '@lang('journal.rev.review_objections')' + ' <span class="req">*</span>';
          commentTextarea.placeholder = '@lang('journal.rev.review_objections_ph')';
          commentTextarea.required = true;
        } else {
          commentLabel.innerHTML = '@lang('journal.rev.comment_label')';
          commentTextarea.placeholder = '@lang('journal.rev.comment_ph')';
          commentTextarea.required = false;
        }
      }
    });
  });

  /* Confirm submit */
  form.addEventListener('submit', function(e){
    var btn = form.querySelector('[data-confirm]');
    if (btn && !confirm(btn.dataset.confirm)) {
      e.preventDefault();
    }
  });
})();
</script>
@endpush
