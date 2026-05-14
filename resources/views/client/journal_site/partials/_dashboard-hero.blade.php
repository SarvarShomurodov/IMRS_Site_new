{{--
  Premium hero greeting card for dashboards.
  Required: $heroEyebrow, $heroTitle
  Optional: $heroSub, $heroBadge (string), $heroBadgeIcon (svg html)
--}}
<header class="jsite-cab-hero">
  <div class="jsite-cab-hero-row">
    <div class="jsite-cab-hero-l">
      <p class="jsite-cab-hero-eyebrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        {{ $heroEyebrow }}
      </p>
      <h1 class="jsite-cab-hero-title">{{ $heroTitle }}</h1>
      @isset($heroSub)
        <p class="jsite-cab-hero-sub">{{ $heroSub }}</p>
      @endisset
    </div>
    <div class="jsite-cab-hero-r">
      <span class="jsite-cab-hero-date">
        {{ now()->locale(app()->getLocale())->isoFormat('D MMMM YYYY · HH:mm') }}
      </span>
      @isset($heroBadge)
        <span class="jsite-cab-hero-badge">
          @isset($heroBadgeIcon)
            {!! $heroBadgeIcon !!}
          @else
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          @endisset
          {{ $heroBadge }}
        </span>
      @endisset
    </div>
  </div>
</header>
