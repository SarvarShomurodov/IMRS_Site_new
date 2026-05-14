@extends('admin.layouts.master')

@section('content')
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Предложение пользователей</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/offers">Предложение пользователей</a></li>
                          <!-- <li class="breadcrumb-item active">Blank Page</li> -->
                      </ol>
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
                      <h4 class="mt-0 header-title">Предложение пользователей </h4>
                      <p class="text-muted mb-4">

                      </p>

                      <div class="table-responsive">
                          <table class="table mb-0">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Имя пользователя</th>
                                      <th>Адрес пользователя</th>
                                      <th>Телефон пользователя</th>
                                      <th>Email пользователя</th>
                                      <th>Контент</th>
                                      <th>Действие</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @php $number = ($items->currentPage()-1)*20; @endphp
                                @foreach($items as $item)
                                  <tr @if($item->status==0) style="background: #C4DEEC" @endif>
                                      <th scope="row">{{++$number}}</th>
                                      <td>{{$item->name}}</td>
                                      <td>{{$item->address}}</td>
                                      <td>{{$item->phone}}</td>
                                      <td>{{$item->email}}</td>
                                      <td>{{$item->getShortContentAttribute()}}</td>
                                      <td>
                                        <a href="/admin/offers/{{$item->id}}" class="text-success mr-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Посмотреть"> Посмотреть</a>
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
