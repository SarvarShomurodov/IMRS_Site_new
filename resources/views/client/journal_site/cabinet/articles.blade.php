@extends('client.journal_site.cabinet._layout')

@section('title', __('journal.cab.my_articles') . ' — IMRS Journal')

@section('cabinet')

<header class="jsite-cab-head">
  <div class="jsite-cab-head-row">
    <div>
      <p class="jsite-cab-eyebrow">{{ __('journal.auth.role_'.$user->role) }}</p>
      <h1 class="jsite-cab-title">@lang('journal.cab.my_articles')</h1>
    </div>
    <a href="{{ route('journal.cabinet.submit') }}" class="jsite-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      <span>@lang('journal.cab.submit_new')</span>
    </a>
  </div>
</header>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty">
    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    <h3>@lang('journal.cab.no_articles')</h3>
    <p>@lang('journal.cab.no_articles_sub')</p>
    <a href="{{ route('journal.cabinet.submit') }}" class="jsite-btn-primary">
      <span>@lang('journal.cab.submit_first')</span>
    </a>
  </div>
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
          <tr>
            <td><span class="jsite-cab-id">#{{ $a->id }}</span></td>
            <td>
              <a href="{{ route('journal.cabinet.article', $a->id) }}" class="jsite-cab-link-title">
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
            <td>{{ $a->created_at->format('Y-m-d H:i') }}</td>
            <td>
              @include('client.journal_site.components.status-badge', ['status' => $a->status])
            </td>
            <td>
              <a href="{{ route('journal.cabinet.article', $a->id) }}" class="jsite-btn-ghost-sm">
                <span>@lang('journal.cab.view')</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="jsite-admin-pagination">
    {{ $articles->links() }}
  </div>
@endif

@endsection
