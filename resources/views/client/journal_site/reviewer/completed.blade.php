@extends('client.journal_site.reviewer._layout')

@section('title', __('journal.rev.completed') . ' — IMRS Journal')

@section('panel')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">@lang('journal.rev.panel') · {{ $reviews->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.rev.completed_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.rev.completed_sub')</p>
</header>

@if ($reviews->isEmpty())
  <div class="jsite-cab-empty">
    <h3>@lang('journal.rev.no_completed')</h3>
  </div>
@else
  <div class="jsite-cab-table-wrap">
    <table class="jsite-cab-table">
      <thead>
        <tr>
          <th>#</th>
          <th>@lang('journal.cab.article_title')</th>
          <th>@lang('journal.mod.reviewer_decision')</th>
          <th>@lang('journal.mod.avg_score')</th>
          <th>@lang('journal.cab.submitted_at')</th>
          <th class="jsite-cab-actions-col">@lang('journal.cab.actions')</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($reviews as $rv)
          <tr>
            <td><span class="jsite-cab-id">#{{ $rv->article->id }}</span></td>
            <td>
              <a href="{{ route('journal.reviewer.article', $rv->article->id) }}" class="jsite-cab-link-title">
                {{ $rv->article->title_orig }}
              </a>
            </td>
            <td>
              @switch($rv->decision)
                @case('accept_no_review')
                  <span class="jsite-status-badge is-success"><span class="jsite-status-text">@lang('journal.rev.decision_accept_no')</span></span>
                  @break
                @case('accept_with_review')
                  <span class="jsite-status-badge is-warn"><span class="jsite-status-text">@lang('journal.rev.decision_accept_with')</span></span>
                  @break
                @case('reject')
                  <span class="jsite-status-badge is-danger"><span class="jsite-status-text">@lang('journal.rev.decision_reject')</span></span>
                  @break
              @endswitch
            </td>
            <td>
              <strong style="font-family:var(--serif);font-size:1.05rem;">{{ $rv->averageScore() ?? '—' }}</strong>
              <small style="color:var(--t3);"> / 5</small>
            </td>
            <td>{{ $rv->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('journal.reviewer.article', $rv->article->id) }}" class="jsite-btn-ghost-sm">
                <span>@lang('journal.cab.view')</span>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="jsite-admin-pagination">{{ $reviews->links() }}</div>
@endif

@endsection
