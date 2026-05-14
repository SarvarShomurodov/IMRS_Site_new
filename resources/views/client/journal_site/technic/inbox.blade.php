@extends('client.journal_site.technic._layout')

@section('title', __('journal.tec.inbox') . ' — IMRS Journal')

@section('panel')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">{{ __('journal.tec.panel') }} · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.tec.inbox_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.tec.inbox_sub')</p>
</header>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty">
    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
    <h3>@lang('journal.tec.no_inbox')</h3>
    <p>@lang('journal.tec.no_inbox_sub')</p>
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
              <a href="{{ route('journal.technic.article', $a->id) }}" class="jsite-cab-link-title">
                {{ $a->title_orig }}
              </a>
              <div class="jsite-cab-row-meta">
                <span class="jsite-cab-mono">{{ $a->file_original_name }}</span>
                @if ($a->file_size)
                  <span class="jsite-cab-dot">·</span>
                  <span>{{ number_format($a->file_size / 1024 / 1024, 1) }} MB</span>
                @endif
              </div>
            </td>
            <td>
              <strong style="display:block;font-size:.85rem;">{{ $a->author->fullName() }}</strong>
              @if ($a->author->workplace)
                <small style="color:var(--t3);font-size:.74rem;">{{ $a->author->workplace }}</small>
              @endif
            </td>
            <td>{{ $a->created_at->format('Y-m-d H:i') }}</td>
            <td>
              <a href="{{ route('journal.technic.article', $a->id) }}" class="jsite-btn-ghost-sm">
                <span>@lang('journal.cab.view')</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
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
