@extends('admin.layouts.master')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="page-title-box">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h4 class="page-title">Сотрудники</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin/employees">Сотрудники</a></li>
            <li class="breadcrumb-item active">Изменить</li>
          </ol>
        </div>
      </div>
    </div>

    @include('admin.includes.alerts')
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="mt-0 header-title">Изменить сотрудника</h4>
          <br>

          <form class="needs-validation" action="/admin/employees/edit/{{ $item->id }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Ф.И.О. (uz)</label>
              <div class="col-sm-12">
                <input class="form-control" name="name_uz" type="text" value="{{ old('name_uz', $item->name_uz) }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Ф.И.О. (ru)</label>
              <div class="col-sm-12">
                <input class="form-control" name="name_ru" type="text" value="{{ old('name_ru', $item->name_ru) }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Ф.И.О. (en)</label>
              <div class="col-sm-12">
                <input class="form-control" name="name_en" type="text" value="{{ old('name_en', $item->name_en) }}">
              </div>
            </div>

            <hr>

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Должность (uz)</label>
              <div class="col-sm-12">
                <input class="form-control" name="position_uz" type="text" value="{{ old('position_uz', $item->position_uz) }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Должность (ru)</label>
              <div class="col-sm-12">
                <input class="form-control" name="position_ru" type="text" value="{{ old('position_ru', $item->position_ru) }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Должность (en)</label>
              <div class="col-sm-12">
                <input class="form-control" name="position_en" type="text" value="{{ old('position_en', $item->position_en) }}" required>
              </div>
            </div>

            <hr>

            @php $currentProjectRu = old('project_ru', $item->project_ru); @endphp
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Проект / отдел</label>
              <div class="col-sm-12">
                <select id="structure_select" class="form-control" required>
                  <option value="">— Выберите —</option>
                  @foreach($structures as $s)
                    <option
                      value="{{ $s->id }}"
                      data-uz="{{ $s->title_uz }}"
                      data-ru="{{ $s->title_ru }}"
                      data-en="{{ $s->title_en }}"
                      {{ $currentProjectRu === $s->title_ru ? 'selected' : '' }}>
                      {{ $s->title_ru }} @if($s->title_uz) / {{ $s->title_uz }} @endif @if($s->title_en) / {{ $s->title_en }} @endif
                    </option>
                  @endforeach
                </select>
                <small class="form-text text-muted">Список берётся из <a href="/admin/structure" target="_blank">«Структура»</a>.</small>
                <input type="hidden" name="project_uz" id="project_uz" value="{{ old('project_uz', $item->project_uz) }}">
                <input type="hidden" name="project_ru" id="project_ru" value="{{ old('project_ru', $item->project_ru) }}">
                <input type="hidden" name="project_en" id="project_en" value="{{ old('project_en', $item->project_en) }}">
              </div>
            </div>

            <script>
              (function () {
                var sel = document.getElementById('structure_select');
                if (!sel) return;
                function sync() {
                  var opt = sel.options[sel.selectedIndex];
                  if (!opt || !opt.value) return;
                  document.getElementById('project_uz').value = opt.dataset.uz || '';
                  document.getElementById('project_ru').value = opt.dataset.ru || '';
                  document.getElementById('project_en').value = opt.dataset.en || '';
                }
                sel.addEventListener('change', sync);
              })();
            </script>

            <hr>

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Email</label>
              <div class="col-sm-12">
                <input class="form-control" name="email" type="email" value="{{ old('email', $item->email) }}">
              </div>
            </div>

            <div class="form-group">
              <label>Фото</label>
              @if($item->image)
                <div class="mb-2"><img src="/images/employees/{{ $item->image }}" width="120"></div>
              @endif
              <input type="file" name="image" class="filestyle" data-buttonname="btn-secondary">
            </div>

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Руководитель команды</label>
              <div class="col-sm-12">
                <select name="head_id" class="form-control">
                  <option value="">— Этот сотрудник сам руководитель —</option>
                  @foreach($heads as $h)
                    <option value="{{ $h->id }}" {{ old('head_id', $item->head_id) == $h->id ? 'selected' : '' }}>
                      {{ $h->name_ru ?: $h->position_ru }} — {{ $h->project_ru }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Порядок (sort)</label>
              <div class="col-sm-12">
                <input class="form-control" name="sort" type="number" value="{{ old('sort', $item->sort) }}">
              </div>
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" value="1" name="is_vacant" id="is_vacant" {{ old('is_vacant', $item->is_vacant) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_vacant">Вакантная позиция</label>
            </div>

            <div class="form-actions">
              <a href="{{ url()->previous() }}" class="btn btn-warning">Назад</a>
              <input type="submit" class="btn btn-success" style="float:right" value="Сохранить">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
