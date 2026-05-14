@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Погода и курс доллара</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/weathers">Погода и курс доллара</a></li>
                          <li class="breadcrumb-item active">Изменить</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/weathers/create">
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
                      <h4 class="mt-0 header-title">Погода и курс доллара</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/weathers/edit/{{$item->id}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Погода на градус Цельсиях (от)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="weather_from"  type="number" value="{{$item->weather_from}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Погода на градус Цельсиях (до)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="weather_to"  type="number" value="{{$item->weather_to}}" required>
                            </div>
                        </div>

                        @foreach($weathers as $weather)
                          <div class="form-check mb-3">
                              <input class="form-check-input" type="radio" name="weather_id" id="exampleRadios{{$weather->id}}" value="{{$weather->id}}" @if($item->weather_id==$weather->id) checked @endif>
                              <label class="form-check-label" for="exampleRadios{{$weather->id}}">
                                  {{$weather->title_ru}} -------- <img src="/images/weathers/{{$weather->image}}" alt="" width="30px">
                              </label>
                          </div>
                        @endforeach

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">$ Покупаем  (uzs)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="usd_from"  type="number" value="{{$item->usd_from}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">$ Продаем  (uzs)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="usd_to"  type="number" value="{{$item->usd_to}}" required>
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
