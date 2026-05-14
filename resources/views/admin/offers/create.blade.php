@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Архивы</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/archives">Архивы</a></li>
                          <li class="breadcrumb-item active">Добавить архив</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/archives/create">
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
                      <h4 class="mt-0 header-title">Архивы (категории новостей)</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/archives/create" method="post">
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
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">Slug (Уникальный, автоматически определяет при пустом значении)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="slug"  type="text" value="{{old('slug')}}">
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
