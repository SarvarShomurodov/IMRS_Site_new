@extends('client.journal_site.moderator._layout')

@section('title', __('journal.mod.all_articles') . ' — IMRS Journal')

@section('panel')

@php
  $allStatuses = [
    'technical_review','revision_requested','technic_rejected',
    'moderator_assign','peer_review','moderator_final','moderator_rejected',
    'ready_to_publish','published',
  ];
@endphp

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">@lang('journal.mod.panel') · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.mod.all_articles')</h1>
</header>

<div class="jsite-admin-role-filter" style="margin-bottom: 1.25rem;">
  <a href="{{ route('journal.moderator.all') }}" @class(['jsite-admin-pill', 'is-act' => $status === ''])>
    {{ __('journal.admin.all_roles') }}
    <span>{{ array_sum($statusCounts->all()) }}</span>
  </a>
  @foreach ($allStatuses as $s)
    <a href="{{ route('journal.moderator.all', ['status' => $s]) }}" @class(['jsite-admin-pill', 'is-act' => $status === $s])>
      {{ __('journal.status.'.$s) }}
      <span>{{ $statusCounts[$s] ?? 0 }}</span>
    </a>
  @endforeach
</div>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty"><h3>—</h3></div>
@else
  <div class="jsite-cab-table-wrap">
    <table class="jsite-cab-table">
      <thead>
        <tr>
          <th>#</th>
          <th>@lang('journal.cab.article_title')</th>
          <th>@lang('journal.tec.submitted_by')</th>
          <th>@lang('journal.cab.submitted_at')</th>
          <th>@lang('journal.cab.status')</th>
          <th class="jsite-cab-actions-col">@lang('journal.cab.actions')</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $a)
          <tr>
            <td><span class="jsite-cab-id">#{{ $a->id }}</span></td>
            <td><a href="{{ route('journal.moderator.article', $a->id) }}" class="jsite-cab-link-title">{{ $a->title_orig }}</a></td>
            <td><span style="font-size:.85rem;">{{ $a->author->fullName() }}</span></td>
            <td>{{ $a->created_at->format('Y-m-d') }}</td>
            <td>@include('client.journal_site.components.status-badge', ['status' => $a->status])</td>
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
