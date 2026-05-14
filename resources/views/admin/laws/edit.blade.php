@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Законы</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/laws">Законы</a></li>
                          <li class="breadcrumb-item active">{{$item->title_ru}}</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/laws/create">
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
                      <h4 class="mt-0 header-title">Законы</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/laws/edit/{{$item->id}}" method="post">
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
                        <div class="form-group">
                            <label class="control-label">Родительский раздел</label>
                            <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="category_id">
                                    <option data-select2-id="3" value="">--------Без родительского раздела--------</option>
                                    @foreach($categories as $category)
                                        @if(!$category->parent()->exists())
                                            <option value="{{$category->id}}" @if($category->child()->exists()) disabled @endif>{{$category->title_ru}}</option>
                                        @endif
                                        @if($category->child()->exists())
                                          @foreach($category->child as $child)
                                            <option value="{{$child->id}}" @if($child->id==$item->category_id) selected @endif > -- {{$child->title_ru}}</option>
                                          @endforeach
                                        @endif
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">URL (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="slug_uz"  type="text" value="{{$item->slug_uz}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">URL (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="slug_ru"  type="text" value="{{$item->slug_ru}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">URL (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="slug_en"  type="text" value="{{$item->slug_en}}">
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
