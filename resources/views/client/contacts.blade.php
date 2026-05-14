@extends('client.layouts.app')

@section('metadata')
  <title>@lang('index.submit_an_offer') | @lang('index.index')</title>
  <meta name="description" content="@lang('index.submit_an_offer') | @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.submit_an_offer')">
  <meta property="og:title" content="@lang('index.submit_an_offer') | @lang('index.index')">
  <meta property="og:description" content="@lang('index.submit_an_offer') | @lang('index.index_des')">
@endsection

@section('content')

<!-- ── HERO ── -->
<section class="ctx-hero" aria-labelledby="ph-h">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">@lang('site.home_breadcrumb')</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span aria-current="page">@lang('index.submit_an_offer')</span>
    </nav>

    <div class="ctx-hero-row" data-aos="fade-up">
      <div class="ctx-hero-l">
        <p class="ctx-hero-eyebrow">
          <span class="ctx-hero-pin" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
          </span>
          @lang('index.contacts')
        </p>
        <h1 class="ctx-hero-title" id="ph-h">@lang('index.submit_an_offer')</h1>
        <p class="ctx-hero-sub">@lang('site.rdx_intro_contacts')</p>
      </div>
      <div class="ctx-hero-r" aria-hidden="true">
        <div class="ctx-radar">
          <span class="ctx-radar-ring ctx-r1"></span>
          <span class="ctx-radar-ring ctx-r2"></span>
          <span class="ctx-radar-ring ctx-r3"></span>
          <span class="ctx-radar-core">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── MAP + GLASS PANEL ── -->
<section class="ctx-stage-sec" aria-label="Map and form">
  <div class="ctx-stage">
    <!-- Map (full width background) -->
    <div class="ctx-map" aria-hidden="false">
      <iframe
        src="https://yandex.com/map-widget/v1/?ll=69.2401%2C41.2995&z=15&pt=69.2401,41.2995,pm2rdm"
        title="IMRS xaritada"
        width="100%" height="100%"
        frameborder="0"
        allowfullscreen
        loading="lazy"></iframe>
      <div class="ctx-map-mask" aria-hidden="true"></div>
    </div>

    <div class="container">
      <div class="ctx-grid">
        <!-- Info cards (glass) -->
        <aside class="ctx-info" data-aos="fade-up">
          <header class="ctx-info-head">
            <p class="ctx-info-eyebrow">@lang('index.contacts')</p>
            <h2 class="ctx-info-title">@lang('site.ftr_address')</h2>
            <p class="ctx-info-sub">@lang('site.rdx_form_intro_short')</p>
          </header>

          <ul class="ctx-cards">
            <li class="ctx-card">
              <div class="ctx-card-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              </div>
              <div class="ctx-card-text">
                <span class="ctx-card-lbl">@lang('index.address')</span>
                <span class="ctx-card-val">@lang('site.ftr_address')</span>
              </div>
            </li>

            <li class="ctx-card">
              <div class="ctx-card-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5 19.79 19.79 0 0 1 1.61 5 2 2 0 0 1 3.6 2.68h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 18l.42-1.08z"/></svg>
              </div>
              <div class="ctx-card-text">
                <span class="ctx-card-lbl">@lang('index.phone')</span>
                <a class="ctx-card-val" href="tel:+998712440247">+998 (71) 244-02-47</a>
              </div>
            </li>

            <li class="ctx-card">
              <div class="ctx-card-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              </div>
              <div class="ctx-card-text">
                <span class="ctx-card-lbl">Email</span>
                <a class="ctx-card-val" href="mailto:info@imrs.uz">info@imrs.uz</a>
              </div>
            </li>

            <li class="ctx-card">
              <div class="ctx-card-ico">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              </div>
              <div class="ctx-card-text">
                <span class="ctx-card-lbl">@lang('index.reception')</span>
                <span class="ctx-card-val">@lang('site.ftr_hours')</span>
              </div>
            </li>
          </ul>
        </aside>

        <!-- Form (glass card) -->
        <div class="ctx-form-wrap" data-aos="fade-up" data-aos-delay="80">
          <header class="ctx-form-head">
            <p class="ctx-form-eyebrow">
              <span class="ctx-form-eyebrow-mark" aria-hidden="true"></span>
              @lang('index.submit_an_offer')
            </p>
            <h2 class="ctx-form-title">@lang('site.rdx_form_title')</h2>
            <p class="ctx-form-sub">@lang('site.rdx_form_below_intro')</p>
          </header>

          @if($errors->any())
            <div class="ctx-alert ctx-alert-err">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              <div>
                <strong>@lang('index.error')</strong>
                <ul style="list-style:none;padding:0;margin:.35rem 0 0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif

          @if(session()->has('success'))
            <div class="ctx-alert ctx-alert-ok">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              <div>
                <strong>@lang('index.success')</strong><br>
                {{ session()->get('success') }}
              </div>
            </div>
          @endif

          <form class="ctx-form" action="{{ route('contacts.post') }}" method="post">
            @csrf
            <div class="ctx-row">
              <div class="ctx-field">
                <input class="ctx-input" id="ctx-name" type="text" name="name" placeholder=" " value="{{ old('name') }}" required>
                <label class="ctx-label" for="ctx-name">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  @lang('index.fio')
                </label>
              </div>
              <div class="ctx-field">
                <input class="ctx-input" id="ctx-address" type="text" name="address" placeholder=" " value="{{ old('address') }}" required>
                <label class="ctx-label" for="ctx-address">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                  @lang('index.address')
                </label>
              </div>
            </div>

            <div class="ctx-row">
              <div class="ctx-field">
                <input class="ctx-input" id="ctx-phone" type="tel" name="phone" placeholder=" " pattern="[0-9()#&+*\-=. ]+" value="{{ old('phone') }}" required>
                <label class="ctx-label" for="ctx-phone">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5 19.79 19.79 0 0 1 1.61 5 2 2 0 0 1 3.6 2.68h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 18l.42-1.08z"/></svg>
                  @lang('index.phone')
                </label>
              </div>
              <div class="ctx-field">
                <input class="ctx-input" id="ctx-email" type="email" name="email" placeholder=" " value="{{ old('email') }}" required>
                <label class="ctx-label" for="ctx-email">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                  Email
                </label>
              </div>
            </div>

            <div class="ctx-field ctx-field-full">
              <textarea class="ctx-textarea" id="ctx-content" name="content" rows="5" placeholder=" " required>{{ old('content') }}</textarea>
              <label class="ctx-label" for="ctx-content">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                @lang('index.message_text')
              </label>
            </div>

            <div class="ctx-actions">
              <span class="ctx-note">* @lang('index.fio'), Email, @lang('index.message_text')</span>
              <button class="ctx-submit" type="submit">
                <span>@lang('index.submit')</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
