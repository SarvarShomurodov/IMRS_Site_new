@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Объявления о защите</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/scolars">Объявления о защите</a></li>
                          <li class="breadcrumb-item active">Добавить ученого</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/scolars/create">
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
                      <h4 class="mt-0 header-title">Ученые</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/scolars/create" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Имя (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="name_uz"  type="text" value="{{old('name_uz')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Имя (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="name_ru"  type="text" value="{{old('name_ru')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Имя (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="name_en"  type="text" value="{{old('name_en')}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Фото</label>
                            <input type="file" name="image" class="filestyle" data-buttonname="btn-secondary" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>Тема (uz)</label>
                            <textarea name="theme_uz" id="theme_uz">{!!old('theme_uz')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Тема (ru)</label>
                            <textarea name="theme_ru" id="theme_ru">{!!old('theme_ru')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Тема (en)</label>
                            <textarea name="theme_en" id="theme_en">{!!old('theme_en')!!}</textarea>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">PhD/DSc (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="phddsc_uz"  type="text" value="{{old('phddsc_uz')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">PhD/DSc (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="phddsc_ru"  type="text" value="{{old('phddsc_ru')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">PhD/DSc (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="phddsc_en"  type="text" value="{{old('phddsc_en')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Место защиты (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="place_uz"  type="text" value="{{old('place_uz')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Место защиты (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="place_ru"  type="text" value="{{old('place_ru')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Место защиты (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="place_en"  type="text" value="{{old('place_en')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-datetime-local-input" class="col-sm-4 col-form-label">Время защиты</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="datetime-local" name="created_at" value="{{old('created_at')}}" placeholder="2011-08-19T13:45:00" id="example-datetime-local-input">
                            </div>
                        </div>

                        <br>
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
    var editor_uz = CKEDITOR.replace('theme_uz');
    var editor_ru = CKEDITOR.replace('theme_ru');
    var editor_en = CKEDITOR.replace('theme_en');

    // CKEDITOR.config.extraPlugins='colorbutton';

    CKFinder.setupCKEditor(editor_ru);
    CKFinder.setupCKEditor(editor_uz);
    CKFinder.setupCKEditor(editor_en);
</script>
@endsection
