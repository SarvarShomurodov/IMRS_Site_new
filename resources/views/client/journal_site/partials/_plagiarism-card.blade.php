{{--
  Plagiarism display block — always visible alongside an article.
  Required: $percent (int 0-100)
--}}
@php
  $p = max(0, min(100, (int) $percent));
  $tone = $p < 20 ? 'is-success' : ($p < 40 ? 'is-info' : ($p < 60 ? 'is-warn' : 'is-danger'));
@endphp
<section class="jsite-cab-block jsite-plagiarism-block {{ $tone }}">
  <div class="jsite-plagiarism-row">
    <div class="jsite-plagiarism-l">
      <span class="jsite-plagiarism-ico" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
      </span>
      <div>
        <p class="jsite-plagiarism-label">@lang('journal.tec.plagiarism')</p>
        <p class="jsite-plagiarism-help">@lang('journal.tec.plagiarism_help')</p>
      </div>
    </div>
    <div class="jsite-plagiarism-r">
      <span class="jsite-plagiarism-num">{{ $p }}<small>%</small></span>
      <div class="jsite-plagiarism-bar" role="progressbar" aria-valuenow="{{ $p }}" aria-valuemin="0" aria-valuemax="100">
        <span style="width: {{ $p }}%"></span>
      </div>
    </div>
  </div>
</section>
