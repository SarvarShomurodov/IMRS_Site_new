<!-- ══ FOOTER ══ -->
<footer id="ftr" role="contentinfo">
  <div class="container">
    <div class="ftr-grid">

      <!-- Brand -->
      <div>
        <div class="ftr-logo">
          <img src="{{ asset('assets/img/logo-dark.png') }}" alt="IMRS — Institute for Macroeconomic and Regional Studies" class="ftr-logo-img">
        </div>
        <p class="ftr-desc">@lang('site.ftr_desc')</p>
        <div class="ftr-address">
          <span><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> @lang('site.ftr_address')</span>
          <span><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5 19.79 19.79 0 0 1 1.61 5 2 2 0 0 1 3.6 2.68h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 18l.42-1.08z"/></svg> <a href="tel:+998712440247" style="color:inherit">+998 (71) 244-02-47</a></span>
          <span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg> <a href="mailto:info@imrs.uz" style="color:inherit">info@imrs.uz</a></span>
          <span><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> @lang('site.ftr_hours')</span>
        </div>
        <nav class="socials" aria-label="@lang('site.ftr_socials')">
          <a href="https://t.me/ifmr_public" class="soc-a" target="_blank" aria-label="Telegram"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Telegram</a>
          <a href="https://www.facebook.com/ifmrpress" class="soc-a" target="_blank" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg> Facebook</a>
          <a href="https://www.youtube.com/channel/UCPcGwPpFOped1Y4IPQcRmVw" class="soc-a" target="_blank" aria-label="YouTube"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg> YouTube</a>
        </nav>
      </div>

      <!-- Institut -->
      <div class="fcol">
        <h4>@lang('site.ftr_col_institute')</h4>
        <ul>
          <li><a href="{{ route('history') }}">@lang('site.history') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('administrations') }}">@lang('site.leadership') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('structure') }}">@lang('site.structure') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('laws', 'laws-and-codes') }}">@lang('site.laws_codes') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('laws', 'decrees') }}">@lang('site.decrees') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('laws', 'resolutions') }}">@lang('site.resolutions') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('laws', 'test-protivodeistvie-korrupcii') }}">@lang('site.anticorruption') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('pages', 'vacancies') }}">@lang('site.vacancies') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
        </ul>
      </div>

      <!-- Nashrlar -->
      <div class="fcol">
        <h4>@lang('site.ftr_col_publications')</h4>
        <ul>
          <li><a href="{{ route('publications', 'articles-and-abstracts') }}">@lang('site.articles_thesis') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'macroeconomics') }}">@lang('site.macroeconomy') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'world-food-markets') }}">@lang('site.world_food_markets') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'industry') }}">@lang('site.industry') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'regional-economy') }}">@lang('site.regional_economy') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'transport-and-logistic') }}">@lang('site.transport_logistics') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'foreign-economic-activity') }}">@lang('site.foreign_trade') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'investments') }}">@lang('site.investments') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('publications', 'social-sphere') }}">@lang('site.social_sphere') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
        </ul>
      </div>

      <!-- Boshqa -->
      <div class="fcol">
        <h4>@lang('site.ftr_col_other')</h4>
        <ul>
          <li><a href="{{ route('archives', 'news') }}">@lang('site.news') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('pages', 'informaciya-o-predstoyashhix-konferenciyax-1') }}">@lang('site.conferences') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('pages', 'sbornik-materialov') }}">@lang('site.materials') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('photos') }}">@lang('site.photogallery') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('videos') }}">@lang('site.videogallery') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('pages', 'for-doctoral-students') }}">@lang('site.science_doctoral') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('pages', 'naucnyi-sovet') }}">@lang('site.science_council_info') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('pages', 'scientific-council-meeting') }}">@lang('site.science_council_meetings') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('protection') }}">@lang('index.protection') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('journals.archive') }}">@lang('site.journal') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
          <li><a href="{{ route('pages', 'webinar') }}">@lang('site.webinars') <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></li>
        </ul>
      </div>

    </div>

    <div class="ftr-bot">
      <p>{!! __('site.ftr_copyright', ['year' => date('Y')]) !!}</p>
      <nav aria-label="@lang('site.ftr_other_links')">
        <ul class="fbot-links">
          <li><a href="{{ url('/contacts') }}" target="_blank">@lang('site.submit_proposal')</a></li>
          <li><a href="#">@lang('site.ftr_privacy')</a></li>
          <li><a href="#">@lang('site.ftr_terms')</a></li>
          <li><a href="#">@lang('site.ftr_sitemap')</a></li>
        </ul>
      </nav>
    </div>
  </div>
</footer>
