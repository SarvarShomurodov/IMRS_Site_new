@extends('client.journal_site.moderator._layout')

@section('title', __('journal.mod.final_queue') . ' — IMRS Journal')

@section('panel')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">@lang('journal.mod.panel') · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.mod.final_queue_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.mod.final_queue_sub')</p>
</header>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty">
    <h3>@lang('journal.mod.no_final_queue')</h3>
  </div>
@else
  <div class="jsite-cab-table-wrap">
    <table class="jsite-cab-table">
      <thead>
        <tr>
          <th>#</th>
          <th>@lang('journal.cab.article_title')</th>
          <th>@lang('journal.tec.submitted_by')</th>
          <th>@lang('journal.mod.avg_score')</th>
          <th class="jsite-cab-actions-col">@lang('journal.cab.actions')</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $a)
          @php
            $allScores = collect();
            foreach ($a->reviews as $r) {
              foreach (\App\Models\JournalReview::SCORE_FIELDS as $f) {
                if ($r->{$f} !== null) $allScores->push($r->{$f});
              }
            }
            $avg = $allScores->avg();
          @endphp
          <tr>
            <td><span class="jsite-cab-id">#{{ $a->id }}</span></td>
            <td><a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-cab-link-title">{{ $a->title_orig }}</a></td>
            <td><span style="font-size:.85rem;">{{ $a->author->fullName() }}</span></td>
            <td>
              @if ($avg !== null)
                <strong style="font-family:var(--serif);font-size:1.15rem;">{{ number_format($avg, 2) }}</strong>
                <small style="color:var(--t3);"> / 5</small>
              @else
                —
              @endif
            </td>
            <td>
              <a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-btn-primary jsite-btn-ghost-sm" style="background:var(--blue-dark);color:#fff;">
                <span>@lang('journal.mod.btn_go_decide')</span>
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
