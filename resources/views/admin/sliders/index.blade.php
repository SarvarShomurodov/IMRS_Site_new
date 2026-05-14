@extends('admin.layouts.master')

@section('content')
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Слайдер</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item active">Слайдер</li>
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
              </div> <!-- end row -->
          </div>
          <!-- end page-title -->

          @include('admin.includes.alerts')

      </div>
      <!-- container-fluid -->
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Слайдер</h4>
                      <p class="text-muted mb-4">

                      </p>

                      <div class="table-responsive">
                          <table class="table mb-0">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Картинка (uz)</th>
                                      <th>Картинка (ru)</th>
                                      <th>Картинка (en)</th>
                                      <th>Активность</th>
                                      <th>Действие</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @php $number = ($items->currentPage()-1)*20; @endphp
                                @foreach($items as $item)
                                  <tr>
                                      <td>{{++$number}}</td>
                                      <td>
                                        <img src="/images/sliders/uz/{{$item->image_uz}}" width="300" alt="">
                                      </td>
                                      <td>
                                        <img src="/images/sliders/ru/{{$item->image_ru}}" width="300" alt="">
                                      </td>
                                      <td>
                                        <img src="/images/sliders/en/{{$item->image_en}}" width="300" alt="">
                                      </td>
                                      <td>
                                        @if($item->status=='active')
                                          Активный
                                        @else
                                          Неактивный
                                        @endif
                                      </td>
                                      <td>
                                        <a href="/admin/sliders/edit/{{$item->id}}" class="text-success mr-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить"> <i class="dripicons-pencil h5 m-0"></i></a>
                                        <a href="javascript:" onclick="deleteArchive(this)" rel="/admin/sliders/delete/{{$item->id}}" class="text-danger" data-toggle="modal" data-target="#myModal" data-placement="top" title="" data-original-title="Удалить" aria-describedby="tooltip934720"> <i class="dripicons-cross h5 m-0"></i></a>

                                      </td>
                                  </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                      {{$items->render()}}
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
