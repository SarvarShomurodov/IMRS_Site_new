@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Разделы закона</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/laws-categories">Разделы закона</a></li>
                          <li class="breadcrumb-item active">{{$item->title_ru}}</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/laws-categories/create">
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
                      <h4 class="mt-0 header-title">Разделы закона</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/laws-categories/edit/{{$item->id}}" method="post">
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
                            <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="parent_id">
                                    <option data-select2-id="3" value="">--------Без родительского раздела--------</option>
                                    @foreach($categories as $category)
                                        @if(!$category->parent()->exists())
                                            <option value="{{$category->id}}" @if($item->parent_id==$category->id) selected @endif>{{$category->title_ru}}</option>
                                        @endif
                                        @if($category->child()->exists())
                                          @foreach($category->child as $child)
                                            <option value="{{$child->id}}" disabled> -- {{$child->title_ru}}</option>
                                          @endforeach
                                        @endif
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">Slug (Уникальный, автоматически определяет при пустом значении)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="slug"  type="text" value="{{$item->slug}}">
                            </div>
                        </div>

                        <br>
                        <p class="text-muted mb-4">Мета данные</p>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Description (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_description_uz"  type="text" value="{{$item->meta_description_uz}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Description (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_description_ru"  type="text" value="{{$item->meta_description_ru}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Description (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_description_en"  type="text" value="{{$item->meta_description_en}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Keywords (uz)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_keywords_uz"  type="text" value="{{$item->meta_keywords_uz}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Keywords (ru)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_keywords_ru"  type="text" value="{{$item->meta_keywords_ru}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Meta Keywords (en)</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="meta_keywords_en"  type="text" value="{{$item->meta_keywords_en}}" required>
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
