@extends('admin.layouts.master')

@section('content')
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Страницы</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item active">Страницы</li>
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
                      <h4 class="mt-0 header-title">Страницы</h4>
                      <p class="text-muted mb-4">

                      </p>

                      <div class="table-responsive">
                          <table class="table mb-0">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Наименование</th>
                                      <th>Детали</th>
                                      <th>Категории</th>
                                      <th>Картинка</th>
                                      <th>Файл</th>
                                      <th>Видео</th>
                                      <th>Slug</th>
                                      <th>Действие</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @php $number = ($items->currentPage()-1)*20; @endphp
                                @foreach($items as $item)
                                  <tr>
                                      <th scope="row">{{++$number}}</th>
                                      <td>{{$item->title_ru}}</td>
                                      <td>{{$item->getShortDescriptionAttribute()}}</td>
                                      <td>
                                        @foreach($item->categories as $category)
                                          <span style="background: #eee; display: block; margin-bottom: 3px">{{$category->title_ru}}</span>

                                        @endforeach
                                      </td>
                                      <td>
                                        <img src="/images/pages/ru/{{$item->image_ru}}" width="60" alt="">
                                      </td>
                                      <td>
                                        <!-- <object data="/files/news/ru/{{$item->pdf_ru}}" type="application/pdf" width="580" height="50"> -->
                                          <a href="/files/pages/ru/{{$item->pdf_ru}}">{{$item->pdf_ru}}</a>
                                        <!-- </object> -->
                                      </td>
                                      <td>
                                        <iframe width="120" height="70" src="{{$item->video_ru}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      </td>
                                      <td>{{$item->slug}}</td>
                                      <td>
                                        <a href="/admin/pages/edit/{{$item->id}}" class="text-success mr-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить"> <i class="dripicons-pencil h5 m-0"></i></a>
                                        <a href="javascript:" onclick="deleteArchive(this)" rel="/admin/pages/delete/{{$item->id}}" class="text-danger" data-toggle="modal" data-target="#myModal" data-placement="top" title="" data-original-title="Удалить" aria-describedby="tooltip934720"> <i class="dripicons-cross h5 m-0"></i></a>

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
