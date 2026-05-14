@extends('admin.layouts.master')

@section('css')
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/multiselect/css/style.css">
@endsection


@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Инфографика</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/infographics">Инфографика</a></li>
                          <li class="breadcrumb-item active">Изменить фото</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/infographics/create">
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
                      <h4 class="mt-0 header-title">Инфографика</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/infographics/edit/{{$item->id}}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_uz"  type="text" value="{{$item->title_uz}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_ru"  type="text" value="{{$item->title_ru}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Заголовок (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="title_en"  type="text" value="{{$item->title_en}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Фото</label>
                            <img src="/images/galleries/{{$item->image}}"  width="400" alt="">
                            <input type="file" name="image" class="filestyle" data-buttonname="btn-secondary" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                        </div>

                        <div class="form-group">
                            <label>Антонация  (uz)</label>
                            <textarea name="antonation_uz" id="antonation_uz">{!!$item->antonation_uz!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Антонация  (ru)</label>
                            <textarea name="antonation_ru" id="antonation_ru">{!!$item->antonation_ru!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Антонация  (en)</label>
                            <textarea name="antonation_en" id="antonation_en">{!!$item->antonation_en!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Хештеги</label>
                            <div class="row justify-content-center">
                      				<div class="col-lg-12 d-flex justify-content-center align-items-center">
                      					<select class="js-select2" multiple="multiple" name="hashtags[]">
                                  @foreach($hashtags as $hashtag)
                        						<option value="{{$hashtag->title}}" @if($hashtag->infographicExists($item->id)) selected @endif data-badge="">{{$hashtag->title}}</option>
                                  @endforeach
                      					</select>
                      				</div>
                      			</div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Сортировка</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="sort"  type="number" value="{{$item->sort}}">
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
@section('script')
<script src="/ckfinder/ckfinder.js"></script>
<script src="/ckeditor/ckeditor.js"></script>

<script>

    var antonation_uz = CKEDITOR.replace('antonation_uz');
    var antonation_ru = CKEDITOR.replace('antonation_ru');
    var antonation_en = CKEDITOR.replace('antonation_en');

    // CKEDITOR.config.extraPlugins='colorbutton';

    CKFinder.setupCKEditor(antonation_ru);
    CKFinder.setupCKEditor(antonation_uz);
    CKFinder.setupCKEditor(antonation_en);

</script>

@endsection

@section('multiselect')
  <script src="/multiselect/js/jquery.min.js"></script>
  <script src="/multiselect/js/popper.js"></script>
  <script src="/multiselect/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
  <script src="/multiselect/js/main.js"></script>
        <script src="{{asset('administrators/assets/js/metismenu.min.js')}}"></script>
        <script src="{{asset('administrators/assets/js/jquery.slimscroll.js')}}"></script>
@endsection
