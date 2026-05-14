@extends('admin.layouts.master')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="page-title-box">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h4 class="page-title">Сотрудники института</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
            <li class="breadcrumb-item active">Сотрудники</li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="float-right d-none d-md-block">
            <a class="btn btn-primary waves-effect waves-light text-white" href="/admin/employees/create">
              <i class="mdi mdi-plus mr-2"></i> Добавить
            </a>
          </div>
        </div>
      </div>
    </div>

    @include('admin.includes.alerts')
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="mt-0 header-title">Список сотрудников</h4>
          <p class="text-muted mb-4">
            Сотрудники с пустым "Руководителем" отображаются на главной странице как руководители проекта.
            Подчинённые им сотрудники показываются при раскрытии карточки.
          </p>

          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Фото</th>
                  <th>Ф.И.О.</th>
                  <th>Должность</th>
                  <th>Проект / отдел</th>
                  <th>Email</th>
                  <th>Руководитель</th>
                  <th>Вакант</th>
                  <th>Sort</th>
                  <th>Действие</th>
                </tr>
              </thead>
              <tbody>
                @php $number = ($items->currentPage() - 1) * 30; @endphp
                @foreach($items as $item)
                  <tr>
                    <th scope="row">{{ ++$number }}</th>
                    <td>
                      @if($item->image)
                        <img src="/images/employees/{{ $item->image }}" width="56" alt="">
                      @else
                        <span class="text-muted">—</span>
                      @endif
                    </td>
                    <td>{{ $item->name_ru ?: '—' }}</td>
                    <td>{{ $item->position_ru }}</td>
                    <td>{{ $item->project_ru }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                      @if($item->head_id)
                        <small class="text-muted">{{ optional($item->head)->name_ru ?: optional($item->head)->position_ru }}</small>
                      @else
                        <span class="badge badge-info">Руководитель</span>
                      @endif
                    </td>
                    <td>
                      @if($item->is_vacant)
                        <span class="badge badge-warning">Вакант</span>
                      @endif
                    </td>
                    <td>{{ $item->sort }}</td>
                    <td>
                      <a href="/admin/employees/edit/{{ $item->id }}" class="text-success mr-3" title="Изменить"><i class="dripicons-pencil h5 m-0"></i></a>
                      <a href="javascript:" onclick="deleteArchive(this)" rel="/admin/employees/delete/{{ $item->id }}" class="text-danger" data-toggle="modal" data-target="#myModal" title="Удалить"><i class="dripicons-cross h5 m-0"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{ $items->render() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
