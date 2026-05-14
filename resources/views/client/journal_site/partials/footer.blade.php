<!-- ══ JOURNAL — FOOTER ══ -->
<footer class="jsite-ftr" role="contentinfo">
  <div class="jsite-container">

    <div class="jsite-ftr-grid">

      <div class="jsite-ftr-col jsite-ftr-brand-col">
        <a href="{{ route('journals') }}" class="jsite-brand">
          <span class="jsite-brand-mark"><em>i</em></span>
          <span class="jsite-brand-text">IMRS</span>
        </a>
        <p class="jsite-ftr-desc">@lang('journal.ftr.desc')</p>
        <p class="jsite-ftr-issn">@lang('journal.ftr.issn')</p>
      </div>

      <div class="jsite-ftr-col">
        <h4 class="jsite-ftr-title">@lang('journal.ftr.about_title')</h4>
        <ul class="jsite-ftr-list">
          <li><a href="#">@lang('journal.ftr.about')</a></li>
          <li><a href="#">@lang('journal.ftr.editorial')</a></li>
          <li><a href="#">@lang('journal.ftr.contact')</a></li>
        </ul>
      </div>

      <div class="jsite-ftr-col">
        <h4 class="jsite-ftr-title">@lang('journal.ftr.authors_title')</h4>
        <ul class="jsite-ftr-list">
          <li><a href="#">@lang('journal.ftr.authors')</a></li>
          <li><a href="#">@lang('journal.ftr.archive')</a></li>
          <li><a href="#">@lang('journal.ftr.submit')</a></li>
        </ul>
      </div>

      <div class="jsite-ftr-col">
        <h4 class="jsite-ftr-title">@lang('journal.ftr.publisher_title')</h4>
        <ul class="jsite-ftr-list">
          <li><a href="#">@lang('journal.ftr.imprint')</a></li>
          <li><a href="#">@lang('journal.ftr.privacy')</a></li>
        </ul>
      </div>

    </div>

    <div class="jsite-ftr-bot">
      <p>{{ __('journal.ftr.copyright', ['year' => date('Y')]) }}</p>
      <p>@lang('journal.ftr.cities')</p>
    </div>

  </div>
</footer>
