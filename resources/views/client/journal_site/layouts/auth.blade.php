<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'IMRS Journal')</title>

<link rel="stylesheet" href="{{ asset('assets/journal/css/journal.css') }}">
<link rel="stylesheet" href="{{ asset('assets/journal/css/auth.css') }}">

<script>
  (function(){ try { var t = localStorage.getItem('imrs-theme'); if (t) document.documentElement.setAttribute('data-theme', t); } catch(e){} })();
</script>

@stack('head')
</head>
<body class="jsite jsite-auth-body">

@php $loc = app()->getLocale(); @endphp

<div class="jsite-auth-wrap">

  <!-- Top minimal bar -->
  <div class="jsite-auth-top">
    <div class="jsite-container jsite-auth-top-row">

      <a href="{{ route('journals') }}" class="jsite-brand">
        <span class="jsite-brand-mark"><em>i</em></span>
        <span class="jsite-brand-text">
          <strong>IMRS</strong>
          <span>Journal</span>
        </span>
      </a>

      <div class="jsite-auth-top-r">
        <div class="jsite-lang">
          <a href="{{ route('changelocale', 'uz') }}" class="@if($loc==='uz') is-act @endif">UZ</a>
          <a href="{{ route('changelocale', 'en') }}" class="@if($loc==='en') is-act @endif">ENG</a>
          <a href="{{ route('changelocale', 'ru') }}" class="@if($loc==='ru') is-act @endif">RUS</a>
        </div>

        <a href="{{ route('journals') }}" class="jsite-auth-back">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          <span>@lang('journal.back_home')</span>
        </a>
      </div>

    </div>
  </div>

  <!-- Auth body -->
  <main class="jsite-auth-main">
    @yield('content')
  </main>

</div>

<script src="{{ asset('assets/journal/js/auth.js') }}" defer></script>
@stack('scripts')

</body>
</html>
