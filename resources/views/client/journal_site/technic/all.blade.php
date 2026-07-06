@extends('client.journal_site.technic._layout')

@section('title', __('journal.tec.all_articles') . ' — IMRS Journal')

@section('panel')

@php
  $allStatuses = [
    'technical_review','revision_requested','technic_rejected',
    'moderator_assign','peer_review','moderator_final','moderator_rejected',
    'ready_to_publish','published',
  ];
@endphp

<header class="jsite-cab-head">
  <p class="jsite-cab-eyebrow">{{ __('journal.tec.panel') }} · {{ $articles->total() }}</p>
  <h1 class="jsite-cab-title">@lang('journal.tec.all_articles')</h1>
</header>

{{-- Status filter pills --}}
<div class="jsite-admin-role-filter" style="margin-bottom: 1.25rem;">
  <a href="{{ route('journal.technic.all') }}" @class(['jsite-admin-pill', 'is-act' => $status === ''])>
    {{ __('journal.admin.all_roles') }}
    <span>{{ array_sum($statusCounts->all()) }}</span>
  </a>
  @foreach ($allStatuses as $s)
    <a href="{{ route('journal.technic.all', ['status' => $s]) }}" @class(['jsite-admin-pill', 'is-act' => $status === $s])>
      {{ __('journal.status.'.$s) }}
      <span>{{ $statusCounts[$s] ?? 0 }}</span>
    </a>
  @endforeach
</div>

@if ($articles->isEmpty())
  <div class="jsite-cab-empty">
    <h3>—</h3>
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
          <th>@lang('journal.cab.status')</th>
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
            <td><span style="font-size:.85rem;">{{ $a->author->fullName() }}</span></td>
            <td>{{ $a->created_at->format('Y-m-d') }}</td>
            <td>@include('client.journal_site.components.status-badge', ['status' => $a->status])</td>
            <td>
              <div class="jsite-cab-row-actions">
                <a href="{{ route('journal.technic.article', $a->id) }}" class="jsite-btn-ico" title="@lang('journal.cab.view')" aria-label="@lang('journal.cab.view')">
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                @if ($a->status === 'published')
                  <a href="{{ route('journal.technic.article.edit', $a->id) }}" class="jsite-btn-ico" title="@lang('journal.tec.btn_edit')" aria-label="@lang('journal.tec.btn_edit')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </a>
                  <form method="POST" action="{{ route('journal.technic.article.destroy', $a->id) }}" class="jsite-inline-form"
                        onsubmit="return confirm('{{ __('journal.tec.delete_confirm') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="jsite-btn-ico jsite-btn-ico-danger" title="@lang('journal.tec.btn_delete')" aria-label="@lang('journal.tec.btn_delete')">
                      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="jsite-admin-pagination">{{ $articles->links() }}</div>
@endif

@endsection

@push('head')
<style>
  .jsite-cab-row-actions { display:flex; align-items:center; gap:.45rem; }
  .jsite-inline-form { display:inline-flex; margin:0; }
  .jsite-btn-ico {
    display:inline-flex; align-items:center; justify-content:center;
    width:34px; height:34px; padding:0;
    border:1px solid var(--bdr); border-radius:8px;
    background:var(--bg-soft, transparent); color:var(--t2);
    cursor:pointer; transition:background .15s, border-color .15s, color .15s;
  }
  .jsite-btn-ico:hover { background:rgba(0,0,0,.05); color:var(--t1); border-color:var(--t3); }
  [data-theme="dark"] .jsite-btn-ico:hover { background:rgba(255,255,255,.07); }
  .jsite-btn-ico-danger { color:#dc2626; border-color:rgba(220,38,38,.35); }
  .jsite-btn-ico-danger:hover { background:rgba(220,38,38,.1); border-color:#dc2626; color:#dc2626; }
</style>
@endpush
