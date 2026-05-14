<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'IMRS — Makroiqtisodiy va Hududiy Tadqiqotlar Instituti')</title>

<link rel="stylesheet" href="{{ asset('assets/css/vendor.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

@stack('head')
</head>
<body>
<div class="scroll-prog" id="scrollProg" aria-hidden="true"></div>

<div id="pbar"></div>
<a href="#main" class="skip-link">@lang('site.skip_to_content')</a>

@include('client.partials.header')
@include('client.partials.mob-nav')

<main id="main">
  @yield('content')
</main>

@include('client.partials.footer')

<button id="stb" aria-label="@lang('site.ftr_back_top')"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg></button>

<script src="{{ asset('assets/js/vendor.js') }}" defer></script>
<script src="{{ asset('assets/js/app.js') }}" defer></script>

@stack('scripts')
</body>
</html>
