@extends('client.journal_site.layouts.app')

@section('title', __('journal.admin.users_title') . ' — ' . __('journal.admin.panel'))

@section('content')

@php
  use App\Models\JournalUser;
  $allRoles = [
    JournalUser::ROLE_USER,
    JournalUser::ROLE_TECHNIC,
    JournalUser::ROLE_MODERATOR,
    JournalUser::ROLE_REVIEWER,
    JournalUser::ROLE_SUPERADMIN,
  ];
@endphp

<section class="jsite-list-sec">
  <div class="jsite-container">

    <header class="jsite-admin-head">
      <div>
        <p class="jsite-hero-meta">{{ __('journal.admin.panel') }} · {{ __('journal.admin.users_title') }}</p>
        <h1 class="jsite-admin-title">
          <em>{{ __('journal.admin.users_title') }}</em>
        </h1>
        <p class="jsite-admin-sub">{{ __('journal.admin.users_sub') }}</p>
      </div>
      <div class="jsite-admin-stats">
        <div class="jsite-admin-stat">
          <b>{{ $users->total() }}</b>
          <span>{{ __('journal.admin.total') }}</span>
        </div>
      </div>
    </header>

    @if (session('success'))
      <div class="jsite-alert jsite-alert-ok">{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="jsite-alert jsite-alert-err">{{ session('error') }}</div>
    @endif

    {{-- Filter / search --}}
    <form method="GET" action="{{ route('journal.admin.users') }}" class="jsite-admin-filters">
      <div class="jsite-input">
        <span class="jsite-input-ico">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </span>
        <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('journal.admin.search_ph') }}">
      </div>

      <div class="jsite-admin-role-filter">
        <a href="{{ route('journal.admin.users') }}" @class(['jsite-admin-pill', 'is-act' => $role === ''])>
          {{ __('journal.admin.all_roles') }}
          <span>{{ array_sum($roleCounts->all()) }}</span>
        </a>
        @foreach ($allRoles as $r)
          <a href="{{ route('journal.admin.users', ['role' => $r] + ($q ? ['q' => $q] : [])) }}"
             @class(['jsite-admin-pill', 'is-act' => $role === $r, 'is-role-'.$r])>
            {{ __('journal.auth.role_'.$r) }}
            <span>{{ $roleCounts[$r] ?? 0 }}</span>
          </a>
        @endforeach
      </div>

      <button type="submit" class="jsite-btn-primary jsite-admin-search-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </button>
    </form>

    {{-- Users table --}}
    @if ($users->count() === 0)
      <div class="jsite-empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <h3>{{ __('journal.admin.no_users') }}</h3>
      </div>
    @else
      <div class="jsite-admin-table-wrap">
        <table class="jsite-admin-table">
          <thead>
            <tr>
              <th>{{ __('journal.admin.name') }}</th>
              <th>{{ __('journal.admin.email') }}</th>
              <th>{{ __('journal.admin.phone') }}</th>
              <th>{{ __('journal.admin.workplace') }}</th>
              <th>{{ __('journal.admin.registered_at') }}</th>
              <th>{{ __('journal.admin.role') }}</th>
              <th class="jsite-admin-actions-col">{{ __('journal.admin.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $u)
              <tr>
                <td>
                  <div class="jsite-admin-user">
                    <span class="jsite-admin-avatar">{{ mb_substr($u->first_name, 0, 1) }}{{ mb_substr($u->last_name, 0, 1) }}</span>
                    <div>
                      <strong>{{ $u->fullName() }}</strong>
                      <small>ID #{{ $u->id }}</small>
                    </div>
                  </div>
                </td>
                <td><span class="jsite-admin-mono">{{ $u->email }}</span></td>
                <td><span class="jsite-admin-mono">{{ $u->phone ?: '—' }}</span></td>
                <td>{{ $u->workplace ?: '—' }}</td>
                <td>{{ $u->created_at?->format('Y-m-d') }}</td>
                <td>
                  <span class="jsite-admin-role-badge is-role-{{ $u->role }}">
                    {{ __('journal.auth.role_'.$u->role) }}
                  </span>
                </td>
                <td>
                  @if ($u->isSuperAdmin())
                    <span class="jsite-admin-locked" title="{{ __('journal.admin.cannot_modify_superadmin') }}">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                  @else
                    <form method="POST" action="{{ route('journal.admin.users.role', $u) }}" class="jsite-admin-role-form">
                      @csrf @method('PATCH')
                      <select name="role" class="jsite-admin-select" data-auto-submit>
                        @foreach (JournalUser::ASSIGNABLE_ROLES as $r)
                          <option value="{{ $r }}" @selected($u->role === $r)>
                            {{ __('journal.auth.role_'.$r) }}
                          </option>
                        @endforeach
                      </select>
                      <button type="submit" class="jsite-admin-save" aria-label="{{ __('journal.admin.save') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                      </button>
                    </form>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="jsite-admin-pagination">
        {{ $users->links() }}
      </div>
    @endif

  </div>
</section>

@endsection

@push('head')
<link rel="stylesheet" href="{{ asset('assets/journal/css/admin.css') }}">
@endpush

@push('scripts')
<script>
  // Auto-submit form when role changes
  document.querySelectorAll('select[data-auto-submit]').forEach(function (sel) {
    var initial = sel.value;
    sel.addEventListener('change', function () {
      if (sel.value !== initial) sel.form.requestSubmit();
    });
  });
</script>
@endpush
