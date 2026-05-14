@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Журналы</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/journals">Журналы</a></li>
                          <li class="breadcrumb-item active">Добавить журнал</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/journals/create">
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
                      <h4 class="mt-0 header-title">Журналы</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/journals/create" method="post" enctype='multipart/form-data'>
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

                        <div class="form-group">
                            <label>Картинка</label>
                            <input type="file" name="image" class="filestyle" data-buttonname="btn-secondary" id="filestyle-4" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>

                        <div class="form-group">
                            <label>Журнал</label>
                            <input type="file" name="journal" class="filestyle" data-buttonname="btn-secondary" id="filestyle-5" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Выпуск (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="time_uz"  type="text" value="{{old('time_uz')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Выпуск (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="time_ru"  type="text" value="{{old('time_ru')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Выпуск (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="time_en"  type="text" value="{{old('time_en')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Сортировка</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="sort" type="number" min="0" step="1" value="{{ old('sort', 0) }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Редакция (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="editorial_staff_uz"  type="text" value="{{old('editorial_staff_uz')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Редакция (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="editorial_staff_ru"  type="text" value="{{old('editorial_staff_ru')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Редакция (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="editorial_staff_en"  type="text" value="{{old('editorial_staff_en')}}" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Редакционная коллегия (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="editorial_board_uz"  type="text" value="{{old('editorial_board_uz')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Редакционная коллегия (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="editorial_board_ru"  type="text" value="{{old('editorial_board_ru')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Редакционная коллегия (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="editorial_board_en"  type="text" value="{{old('editorial_board_en')}}" >
                            </div>
                        </div>



                        <div class="form-group">
                            <label>Требования к статье (uz)</label>
                            <textarea name="submission_uz" id="submission_uz">{!!old('submission_uz')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Требования к статье (ru)</label>
                            <textarea name="submission_ru" id="submission_ru">{!!old('submission_ru')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Требования к статье (en)</label>
                            <textarea name="submission_en" id="submission_en">{!!old('submission_en')!!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Новости  (uz)</label>
                            <textarea name="news_uz" id="news_uz">{!!old('news_uz')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Новости  (ru)</label>
                            <textarea name="news_ru" id="news_ru">{!!old('news_ru')!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Новости  (en)</label>
                            <textarea name="news_en" id="news_en">{!!old('news_en')!!}</textarea>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Подписка (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="subscription_uz"  type="text" value="{{old('subscription_uz')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Подписка (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="subscription_ru"  type="text" value="{{old('subscription_ru')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Подписка (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="subscription_en"  type="text" value="{{old('subscription_en')}}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Контакты (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="contacts_uz"  type="text" value="{{old('contacts_uz')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Контакты (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="contacts_ru"  type="text" value="{{old('contacts_ru')}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Контакты (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="contacts_en"  type="text" value="{{old('contacts_en')}}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">ISSN</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="issn"  type="text" value="{{old('issn')}}" >
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
<script src="/ckfinder/ckfinder.js"></script>
<script src="/ckeditor/ckeditor.js"></script>

<script>
    var editor_uz = CKEDITOR.replace('submission_uz');
    var editor_ru = CKEDITOR.replace('submission_ru');
    var editor_en = CKEDITOR.replace('submission_en');

    var news_uz = CKEDITOR.replace('news_uz');
    var news_ru = CKEDITOR.replace('news_ru');
    var news_en = CKEDITOR.replace('news_en');

    // CKEDITOR.config.extraPlugins='colorbutton';

    CKFinder.setupCKEditor(editor_ru);
    CKFinder.setupCKEditor(editor_uz);
    CKFinder.setupCKEditor(editor_en);

    CKFinder.setupCKEditor(news_ru);
    CKFinder.setupCKEditor(news_uz);
    CKFinder.setupCKEditor(news_en);

</script>
@endsection
