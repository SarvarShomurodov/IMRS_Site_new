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
                          <p>Имя пользователя: <span>{{$item->name}}</span>  </p>
                          <p>Телефон пользователя: <span>{{$item->address}}</span>  </p>
                          <p>Телефон пользователя: <span>{{$item->phone}}</span>  </p>
                          <p>Email пользователя: <span>{{$item->email}}</span>  </p>
                          <br><br><br>
                          <span>
                            {{$item->content}}
                          </span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
