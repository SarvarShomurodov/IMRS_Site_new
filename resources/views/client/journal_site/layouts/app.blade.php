<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'IMRS Journal')</title>

<link rel="stylesheet" href="{{ asset('assets/journal/css/journal.css') }}">

<script>
  // FOUC oldini olish — theme'ni darhol qo'llash
  (function(){ try { var t = localStorage.getItem('imrs-theme'); if (t) document.documentElement.setAttribute('data-theme', t); } catch(e){} })();
</script>

@stack('head')
</head>
<body class="jsite">

@include('client.journal_site.partials.header')

<main id="jsite-main">
  @yield('content')
</main>

@include('client.journal_site.partials.footer')

<script src="{{ asset('assets/journal/js/journal.js') }}" defer></script>

@stack('scripts')
</body>
</html>
