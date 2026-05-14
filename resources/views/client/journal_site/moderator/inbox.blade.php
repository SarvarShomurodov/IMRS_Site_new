@extends('client.journal_site.moderator._layout')

@section('title', __('journal.mod.inbox') . ' — IMRS Journal')

@section('panel')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">@lang('journal.mod.panel') · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.mod.inbox_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.mod.inbox_sub')</p>
</header>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty">
    <h3>@lang('journal.mod.no_inbox')</h3>
  </div>
@else
  <div class="jsite-cab-table-wrap">
    <table class="jsite-cab-table">
      <thead>
        <tr>
          <th>#</th>
          <th>@lang('journal.cab.article_title')</th>
          <th>@lang('journal.tec.submitted_by')</th>
          <th>@lang('journal.cab.submitted_at')</th>
          <th class="jsite-cab-actions-col">@lang('journal.cab.actions')</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $a)
          <tr>
            <td><span class="jsite-cab-id">#{{ $a->id }}</span></td>
            <td>
              <a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-cab-link-title">{{ $a->title_orig }}</a>
              <div class="jsite-cab-row-meta">
                <span class="jsite-cab-mono">{{ $a->file_original_name }}</span>
              </div>
            </td>
            <td>
              <strong style="display:block;font-size:.85rem;">{{ $a->author->fullName() }}</strong>
              @if ($a->author->workplace)
                <small style="color:var(--t3);font-size:.74rem;">{{ $a->author->workplace }}</small>
              @endif
            </td>
            <td>{{ $a->created_at->format('Y-m-d') }}</td>
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
