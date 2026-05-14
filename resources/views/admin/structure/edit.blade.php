@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Структура</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/structure">Структура</a></li>
                          <li class="breadcrumb-item active">Изменить структуру</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/structure/create">
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
                      <h4 class="mt-0 header-title">Структура</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/structure/edit/{{$item->id}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_uz"  type="text" value="{{$item->title_uz}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_ru"  type="text" value="{{$item->title_ru}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_en"  type="text" value="{{$item->title_en}}" required>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" value="1" @if($item->type==1) checked @endif name="type" id="oval">
                            <label class="form-check-label" for="oval">
                                Тип (круглые углы)
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" value="2" @if($item->type==2) checked @endif name="type" id="noval">
                            <label class="form-check-label" for="noval">
                                Тип (острые углы)
                            </label>
                        </div>
                        <br>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="hidden" value="no" name="is_parent">
                            <input class="form-check-input" type="checkbox" value="yes" name="is_parent" id="is_parent" @if($item->is_parent=='yes') checked @endif>
                            <label class="form-check-label" for="is_parent">
                                Родительский раздел
                            </label>
                        </div>
                        <hr>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" value="1" name="column" id="column1" @if($item->column==1) checked @endif>
                            <label class="form-check-label" for="column1">
                                1 - Столбец
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" value="2" name="column" id="column2" @if($item->column==2) checked @endif>
                            <label class="form-check-label" for="column2">
                                2 - Столбец
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" value="3" name="column" id="column3" @if($item->column==3) checked @endif>
                            <label class="form-check-label" for="column3">
                                3 - Столбец
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" value="4" name="column" id="column4" @if($item->column==4) checked @endif>
                            <label class="form-check-label" for="column4">
                                4 - Столбец
                            </label>
                        </div>

                        <div class="form-group row">
                              <label for="example-text-input" class="col-sm-4 col-form-label">Сортировка</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="sort"  type="number" value="{{$item->sort}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">URL</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="slug"  type="text" value="{{$item->slug}}">
                            </div>
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
