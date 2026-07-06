@extends('admin.layouts.master')

@section('content')
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Фоны страниц</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item active">Фоны страниц</li>
                      </ol>
                  </div>
              </div> <!-- end row -->
          </div>
          <!-- end page-title -->

          @include('admin.includes.alerts')

          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

      </div>
      <!-- container-fluid -->
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Фоновые изображения страниц</h4>
                      <p class="text-muted mb-4">
                          Для каждой страницы можно задать своё фоновое изображение (hero).
                          Рекомендуемый размер — не менее 1920×800px (jpg, png, webp).
                      </p>

                      <div class="table-responsive">
                          <table class="table mb-0 align-middle">
                              <thead>
                                  <tr>
                                      <th style="width:50px">#</th>
                                      <th>Страница</th>
                                      <th style="width:320px">Текущий фон</th>
                                      <th>Загрузить новое изображение</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($items as $i => $item)
                                  <tr>
                                      <td>{{ $i + 1 }}</td>
                                      <td>
                                        <strong>{{ $item->name }}</strong><br>
                                        <small class="text-muted">{{ $item->page_key }}</small>
                                      </td>
                                      <td>
                                        @if($item->video)
                                          <video src="/images/page-heroes/{{ $item->video }}" width="280" style="border-radius:6px;object-fit:cover;display:block" muted loop autoplay playsinline></video>
                                          <div class="mt-1 mb-2">
                                            <span class="badge badge-soft-primary"><i class="mdi mdi-video"></i> Видео-фон</span>
                                            <a href="/admin/page-heroes/remove-video/{{ $item->id }}"
                                               class="text-danger ml-2"
                                               onclick="return confirm('Удалить фоновое видео этой страницы?')">
                                               <i class="dripicons-cross"></i> Удалить видео
                                            </a>
                                          </div>
                                        @endif

                                        @if($item->image)
                                          <img src="/images/page-heroes/{{ $item->image }}" width="280" style="border-radius:6px;object-fit:cover" alt="">
                                          <div class="mt-2">
                                            <a href="/admin/page-heroes/remove/{{ $item->id }}"
                                               class="text-danger"
                                               onclick="return confirm('Удалить фоновое изображение этой страницы?')">
                                               <i class="dripicons-cross"></i> Удалить фон
                                            </a>
                                          </div>
                                        @endif

                                        @if(!$item->image && !$item->video)
                                          <span class="badge badge-soft-secondary">Нет изображения (показывается градиент)</span>
                                        @endif
                                      </td>
                                      <td>
                                        <form action="/admin/page-heroes/update/{{ $item->id }}" method="post" enctype="multipart/form-data">
                                          @csrf
                                          <div class="form-group mb-2">
                                            <label class="mb-1">Изображение (jpg, png, webp)</label>
                                            <input type="file" name="image" accept="image/*" class="form-control">
                                          </div>
                                          <div class="form-group mb-2">
                                            <label class="mb-1">Видео-фон (mp4, webm · до 60 МБ)</label>
                                            <input type="file" name="video" accept="video/mp4,video/webm,video/ogg" class="form-control">
                                            <small class="text-muted">Если загружено видео — оно показывается вместо изображения.</small>
                                          </div>
                                          <div class="form-group mb-2">
                                            <label class="mb-1">Положение фото</label>
                                            <select name="position" class="form-control">
                                              <option value="top"    @if($item->position=='top') selected @endif>Верх — сохранять головы</option>
                                              <option value="center" @if($item->position=='center' || !$item->position) selected @endif>Центр</option>
                                              <option value="bottom" @if($item->position=='bottom') selected @endif>Низ</option>
                                            </select>
                                          </div>
                                          <button type="submit" class="btn btn-success btn-sm">
                                            <i class="mdi mdi-content-save mr-1"></i> Сохранить
                                          </button>
                                        </form>
                                      </td>
                                  </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
