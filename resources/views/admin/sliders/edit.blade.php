@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Слайдер</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/sliders">Слайдер</a></li>
                          <li class="breadcrumb-item active">Изменить фото</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/sliders/create">
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
                      <h4 class="mt-0 header-title">Слайдер</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/sliders/edit/{{$item->id}}" method="post" enctype='multipart/form-data'>
                        @csrf

                        <div class="form-group">
                            <label>Фото (uz)</label>
                            <img src="/images/sliders/uz/{{$item->image_uz}}" alt="" width="300">
                            <input type="file" name="image_uz" class="filestyle" data-buttonname="btn-secondary" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>Фото (ru)</label>
                            <img src="/images/sliders/ru/{{$item->image_ru}}" alt="" width="300">
                            <input type="file" name="image_ru" class="filestyle" data-buttonname="btn-secondary" id="filestyle-1" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-group">
                            <label>Фото (en)</label>
                            <img src="/images/sliders/en/{{$item->image_en}}" alt="" width="300">
                            <input type="file" name="image_en" class="filestyle" data-buttonname="btn-secondary" id="filestyle-2" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>
                        <div class="form-check mb-3">
                            <input type="hidden" name="status" value="inactive">
                            <input class="form-check-input" type="checkbox" value="active" name="status" id="status" @if($item->status=='active') checked @endif>
                            <label class="form-check-label" for="status">
                                Активный
                            </label>
                        </div>

                        <div class="form-actions">
                          <a href="{{ url()->previous() }}" class="btn btn-warning" style=";">Назад</a>
                          <input type="submit" name="submit" class="btn btn-success" style="float: Right" value="Сохранить">
                        </div>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
@section('script')

@endsection
