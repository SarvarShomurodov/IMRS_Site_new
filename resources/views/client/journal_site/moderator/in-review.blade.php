@extends('client.journal_site.moderator._layout')

@section('title', __('journal.mod.in_review') . ' — IMRS Journal')

@section('panel')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">@lang('journal.mod.panel') · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.mod.in_review_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.mod.in_review_sub')</p>
</header>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty">
    <h3>@lang('journal.mod.no_in_review')</h3>
  </div>
@else
  <div class="jsite-cab-table-wrap">
    <table class="jsite-cab-table">
      <thead>
        <tr>
          <th>#</th>
          <th>@lang('journal.cab.article_title')</th>
          <th>@lang('journal.mod.peer_section')</th>
          <th class="jsite-cab-actions-col">@lang('journal.cab.actions')</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $a)
          @php
            $assigned = $a->assignedReviewers->count();
            $done = $a->reviews->count();
          @endphp
          <tr>
            <td><span class="jsite-cab-id">#{{ $a->id }}</span></td>
            <td>
              <a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-cab-link-title">{{ $a->title_orig }}</a>
              <div class="jsite-cab-row-meta">
                <span>{{ $a->author->fullName() }}</span>
              </div>
            </td>
            <td>
              <div class="jsite-mod-progress">
                <div class="jsite-mod-progress-bar" style="--p: {{ $assigned > 0 ? ($done / $assigned * 100) : 0 }}%"></div>
                <span>{{ $done }} / {{ $assigned }}</span>
              </div>
            </td>
            <td>
              <a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-btn-ghost-sm">
                <span>@lang('journal.cab.view')</span>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="jsite-admin-pagination">{{ $articles->links() }}</div>
@endif

@endsection
