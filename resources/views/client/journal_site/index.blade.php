@extends('client.journal_site.layouts.app')

@section('title', __('journal.list.page_title'))

@section('content')

@php
  $loc = app()->getLocale();
  $activeYear = request('year');
  $activeCat  = request('cat');
  $activeTag  = request('tag');
@endphp

<!-- ══ LIST + SIDEBAR ══ -->
<section class="jsite-list-sec">
  <div class="jsite-container">
    <div class="jsite-list-grid">

      <!-- ── Sidebar ── -->
      <aside class="jsite-side">

        <div class="jsite-side-block">
          <h4 class="jsite-side-title">@lang('journal.list.sidebar_issues')</h4>
          @if(empty($years))
            <p class="jsite-side-empty">—</p>
          @else
            <ul class="jsite-side-years">
              @foreach($years as $y)
                <li data-year="{{ $y['y'] }}" @class(['is-act' => !empty($y['act'])])>
                  <a href="{{ route('journals', ['year' => $y['y']]) }}">
                    <span class="jsite-side-y-num">{{ $y['y'] }}</span>
                    <span class="jsite-side-y-cnt">{{ $y['n'] }}</span>
                  </a>
                </li>
              @endforeach
            </ul>
          @endif
        </div>

        <div class="jsite-side-block">
          <h4 class="jsite-side-title">@lang('journal.list.sidebar_tags')</h4>
          @if(empty($tags))
            <p class="jsite-side-empty">—</p>
          @else
            <ul class="jsite-side-tags">
              @foreach($tags as $tag)
                <li><a href="{{ route('journals', ['tag' => $tag]) }}" data-tag="{{ $tag }}" @class(['is-act' => $activeTag === $tag])>#{{ $tag }}</a></li>
              @endforeach
            </ul>
          @endif
        </div>

        <a href="{{ route('journals') }}" class="jsite-side-clear">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          <span>@lang('journal.list.sidebar_clear')</span>
        </a>

        <a href="{{ route('journal.issues') }}" class="jsite-side-issues-btn">
          <span class="jsite-side-issues-ico" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
          </span>
          <span class="jsite-side-issues-txt">
            <strong>@lang('journal.issues.page_title')</strong>
            <small>@lang('journal.issues.btn_sub')</small>
          </span>
          <svg class="jsite-side-issues-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

      </aside>

      <!-- ── Main ── -->
      <div class="jsite-main">

        <header class="jsite-main-head">
          <h2 class="jsite-main-title">@lang('journal.list.active_filters')</h2>
          <span class="jsite-main-count" data-count>{{ __('journal.list.count_found', ['n' => $totalCount]) }}</span>
        </header>

        <div class="jsite-active-filters"
             id="jsiteActiveFilters"
             data-empty-text="@lang('journal.list.no_filter')"
             data-chip-remove="@lang('journal.list.chip_remove')">
          <span class="jsite-active-empty">@lang('journal.list.no_filter')</span>
        </div>

        <div class="jsite-toolbar"
             data-count-template="@lang('journal.list.count_found', ['n' => '__N__'])">
          <span class="jsite-toolbar-count" data-count>{{ __('journal.list.count_found', ['n' => $totalCount]) }}</span>
          <div class="jsite-toolbar-r">
            <label class="jsite-sort">
              <span class="jsite-sort-lbl">@lang('journal.list.sort_label')</span>
              <select id="jsiteSort">
                <option value="new">@lang('journal.list.sort_new')</option>
                <option value="old">@lang('journal.list.sort_old')</option>
                <option value="popular">@lang('journal.list.sort_popular')</option>
                <option value="title">@lang('journal.list.sort_title')</option>
              </select>
            </label>
            <div class="jsite-view-toggle" role="group" aria-label="View">
              <button type="button" class="is-act" data-view="grid" aria-label="@lang('journal.list.view_grid')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
              </button>
              <button type="button" data-view="list" aria-label="@lang('journal.list.view_list')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
              </button>
            </div>
          </div>
        </div>

        @if($articles->isEmpty())
          <div class="jsite-empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <h3>@lang('journal.list.empty_no_articles')</h3>
            <p>@lang('journal.list.empty_no_articles_sub')</p>
          </div>
        @else
          <ul class="jsite-articles is-grid-mode" id="jsiteArticles">
            @foreach($articles as $a)
              @php
                $title   = $a->title_publish ?: $a->title_orig;
                $excerpt = (string) ($a->description ?? '');
                $excerptShort = \Illuminate\Support\Str::limit(strip_tags($excerpt), 180);
                $authorName = $a->author ? $a->author->fullName() : '—';
                $pubDate = $a->publish_date ?: $a->updated_at;
                $year    = $pubDate ? $pubDate->format('Y') : '';
                $dateD   = $pubDate ? $pubDate->locale($loc)->isoFormat('YYYY · D MMM') : '';
                $tagsArr = is_array($a->tags) ? $a->tags : [];
                $cover   = $a->cover ? asset('storage/' . $a->cover) : null;
                $cat     = $a->category ?: '—';
              @endphp
              <li class="jsite-article"
                  data-cat="{{ $cat }}"
                  data-year="{{ $year }}"
                  data-tags="{{ implode(',', $tagsArr) }}"
                  data-title="{{ \Illuminate\Support\Str::lower($title) }}"
                  data-excerpt="{{ \Illuminate\Support\Str::lower($excerptShort) }}"
                  data-author="{{ \Illuminate\Support\Str::lower($authorName) }}"
                  data-views="{{ (int) $a->views }}"
                  data-date="{{ $pubDate ? $pubDate->format('Y-m-d') : '' }}">
                <a href="{{ route('journal', $a->id) }}" class="jsite-article-cover">
                  @if($cover)
                    <img src="{{ $cover }}" alt="{{ $title }}" loading="lazy">
                  @else
                    <div class="jsite-article-cover-fb">
                      <span>IMRS</span>
                      <small>№{{ $a->id }}</small>
                    </div>
                  @endif
                  @if($a->category)
                    <span class="jsite-article-tag">{{ $a->category }}</span>
                  @endif
                </a>
                <div class="jsite-article-body">
                  <h3 class="jsite-article-title">
                    <a href="{{ route('journal', $a->id) }}">{{ $title }}</a>
                  </h3>
                  @if($excerptShort)
                    <p class="jsite-article-excerpt">{{ $excerptShort }}</p>
                  @endif
                  <div class="jsite-article-foot">
                    <span class="jsite-article-author">{{ $authorName }}</span>
                    @if($dateD)
                      <span class="jsite-article-dot">·</span>
                      <span class="jsite-article-date">{{ $dateD }}</span>
                    @endif
                    <span class="jsite-article-views">
                      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      {{ number_format((int) $a->views) }}
                    </span>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>

          <div class="jsite-empty-state" id="jsiteEmpty" hidden>
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <h3>@lang('journal.list.empty_no_results')</h3>
            <p>@lang('journal.list.empty_no_results_sub')</p>
            <button type="button" class="jsite-btn-ghost" id="jsiteEmptyClear">@lang('journal.list.empty_clear')</button>
          </div>
        @endif

      </div>

    </div>
  </div>
</section>

@endsection
