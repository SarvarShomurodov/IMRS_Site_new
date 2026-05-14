@extends('client.journal_site.technic._layout')

@section('title', __('journal.tec.publish_queue') . ' — IMRS Journal')

@section('panel')

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">{{ __('journal.tec.panel') }} · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.tec.publish_queue_title')</h1>
  <p class="jsite-cab-sub">@lang('journal.tec.publish_queue_sub')</p>
</header>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty">
    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
    <h3>@lang('journal.tec.no_publish_queue')</h3>
  </div>
@else
  <div class="jsite-cab-table-wrap">
    <table class="jsite-cab-table">
      <thead>
        <tr>
          <th>#</th>
          <th>@lang('journal.cab.article_title')</th>
          <th>@lang('journal.tec.submitted_by')</th>
          <th>@lang('journal.tec.category')</th>
          <th class="jsite-cab-actions-col">@lang('journal.cab.actions')</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $a)
          <tr>
            <td><span class="jsite-cab-id">#{{ $a->id }}</span></td>
            <td>
              <a href="{{ route('journal.technic.article', $a->id) }}" class="jsite-cab-link-title">{{ $a->title_orig }}</a>
            </td>
            <td><strong style="font-size:.85rem;">{{ $a->author->fullName() }}</strong></td>
            <td>
              @if ($a->category)
                <span class="jsite-cab-cat-pill">{{ $a->category }}</span>
              @else
                —
              @endif
            </td>
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
