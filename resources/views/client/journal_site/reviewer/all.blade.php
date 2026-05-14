@extends('client.journal_site.reviewer._layout')

@section('title', __('journal.rev.all_articles') . ' — IMRS Journal')

@section('panel')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">@lang('journal.rev.panel') · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.rev.all_articles')</h1>
</header>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty"><h3>—</h3></div>
@else
  <div class="jsite-cab-table-wrap">
    <table class="jsite-cab-table">
      <thead>
        <tr>
          <th>#</th>
          <th>@lang('journal.cab.article_title')</th>
          <th>@lang('journal.cab.submitted_at')</th>
          <th>@lang('journal.cab.status')</th>
          <th class="jsite-cab-actions-col">@lang('journal.cab.actions')</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $a)
          @php $myReview = $a->reviews->first(); @endphp
          <tr>
            <td><span class="jsite-cab-id">#{{ $a->id }}</span></td>
            <td>
              <a href="{{ route('journal.reviewer.article', $a->id) }}" class="jsite-cab-link-title">{{ $a->title_orig }}</a>
            </td>
            <td>{{ $a->updated_at->format('Y-m-d') }}</td>
            <td>
              @if ($myReview)
                <span class="jsite-status-badge is-success"><span class="jsite-status-text">@lang('journal.mod.reviewer_status_completed')</span></span>
              @else
                <span class="jsite-status-badge is-warn"><span class="jsite-status-text">@lang('journal.mod.reviewer_status_pending')</span></span>
              @endif
            </td>
            <td>
              <a href="{{ route('journal.reviewer.article', $a->id) }}" class="jsite-btn-ghost-sm">
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
