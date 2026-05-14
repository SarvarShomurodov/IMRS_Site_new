@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Администрация</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/administrations">Администрация</a></li>
                          <li class="breadcrumb-item active">Добавить </li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/administrations/create">
                                  <i class="mdi mdi-plus mr-2"></i> Добавить
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- end bred-crumbs -->

          @include('admin.includes.alerts')
      </div>
      <!-- container-fluid -->
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Администрация</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/administrations/create" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Должность (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_uz"  type="text" value="{{old('title_uz')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Должность (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_ru"  type="text" value="{{old('title_ru')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Должность (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_en"  type="text" value="{{old('title_en')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Ф.И.О (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="name_uz"  type="text" value="{{old('name_uz')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Ф.И.О (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="name_ru"  type="text" value="{{old('name_ru')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Ф.И.О (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="name_en"  type="text" value="{{old('name_en')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="email"  type="text" value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Телефон</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="phone"  type="text" value="{{old('phone')}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Фото </label>
                            <input type="file" name="image" class="filestyle" data-buttonname="btn-secondary" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Обязанности (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="duties_uz"  type="text" value="{{old('duties_uz')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Обязанности (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="duties_ru"  type="text" value="{{old('duties_ru')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Обязанности (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="duties_en"  type="text" value="{{old('duties_en')}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Биография (uz)</label>
                            <textarea name="biography_uz" id="description_uz">{!!old('biography_uz')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Биография (ru)</label>
                            <textarea name="biography_ru" id="description_ru">{!!old('biography_ru')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Биография (en)</label>
                            <textarea name="biography_en" id="description_en">{!!old('biography_en')!!}</textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="yes" name="vacant" id="vacant">
                            <label class="form-check-label" for="vacant">
                                Вакант
                            </label>
                        </div>
                        <div class="form-actions">
                          <a href="{{ url()->previous() }}" class="btn btn-warning" style=";">Назад</a>
                          <input type="submit" name="submit" class="btn btn-success" style="float: Right" value="Создать">
                        </div>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="/ckfinder/ckfinder.js"></script>
<script>
    var editor_uz = CKEDITOR.replace('description_uz');
    var editor_ru = CKEDITOR.replace('description_ru');
    var editor_en = CKEDITOR.replace('description_en');

    // CKEDITOR.config.extraPlugins='colorbutton';

    CKFinder.setupCKEditor(editor_ru);
    CKFinder.setupCKEditor(editor_uz);
    CKFinder.setupCKEditor(editor_en);
</script>
@endsection
