@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Страницы</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/pages">Страницы</a></li>
                          <li class="breadcrumb-item active">Добавить страницу</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/pages/create">
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
                      <h4 class="mt-0 header-title">Страницы</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/pages/create" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_uz"  type="text" value="{{old('title_uz')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_ru"  type="text" value="{{old('title_ru')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_en"  type="text" value="{{old('title_en')}}" required>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="control-label">Выберите категорию</label>

                            <select name="category[]" class="select2 form-control select2-multiple select2-hidden-accessible" multiple="" data-placeholder="Choose ..." data-select2-id="4" tabindex="-1" aria-hidden="true">
                                @foreach($categories as $category)
                                  <option value="{{$category->id}}">{{$category->title_ru}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Фото (uz)</label>
                            <input type="file" name="image_uz" class="filestyle" data-buttonname="btn-secondary" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>Фото (ru)</label>
                            <input type="file" name="image_ru" class="filestyle" data-buttonname="btn-secondary" id="filestyle-1" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>Фото (en)</label>
                            <input type="file" name="image_en" class="filestyle" data-buttonname="btn-secondary" id="filestyle-2" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>Детали (uz)</label>
                            <textarea name="description_uz" id="description_uz">{!!old('description_uz')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Детали (ru)</label>
                            <textarea name="description_ru" id="description_ru">{!!old('description_ru')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Детали (en)</label>
                            <textarea name="description_en" id="description_en">{!!old('description_en')!!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>pdf (uz)</label>
                            <input type="file" name="pdf_uz" class="filestyle" data-buttonname="btn-secondary" id="filestyle-3" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>pdf (ru)</label>
                            <input type="file" name="pdf_ru" class="filestyle" data-buttonname="btn-secondary" id="filestyle-4" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>pdf (en)</label>
                            <input type="file" name="pdf_en" class="filestyle" data-buttonname="btn-secondary" id="filestyle-5" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">Slug (Уникальный, автоматически определяет при пустом значении)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="slug"  type="text" value="{{old('slug')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Видео (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="video_uz"  type="text" value="{{old('video_uz')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Видео (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="video_ru"  type="text" value="{{old('video_ru')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Видео (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="video_en"  type="text" value="{{old('video_en')}}">
                            </div>
                        </div>

                        <br>
                        <p class="text-muted mb-4">Мета данные</p>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Description (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_description_uz"  type="text" value="{{old('meta_description_uz')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Description (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_description_ru"  type="text" value="{{old('meta_description_ru')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Description (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_description_en"  type="text" value="{{old('meta_description_en')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Keywords (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_keywords_uz"  type="text" value="{{old('meta_keywords_uz')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Keywords (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_keywords_ru"  type="text" value="{{old('meta_keywords_ru')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Keywords (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_keywords_en"  type="text" value="{{old('meta_keywords_en')}}" required>
                            </div>
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
