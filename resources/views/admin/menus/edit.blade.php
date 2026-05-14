@extends('admin.layouts.master')

@section('content')

<!-- bred-crumbs -->
  <div class="content">
      <div class="container-fluid">
          <div class="page-title-box">
              <div class="row align-items-center">
                  <div class="col-sm-6">
                      <h4 class="page-title">Меню</h4>
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item"><a href="/admin/menus">Меню</a></li>
                          <li class="breadcrumb-item active">{{$item->title_ru}}</li>
                      </ol>
                  </div>
                  <div class="col-sm-6">
                      <div class="float-right d-none d-md-block">
                          <div class="dropdown">
                              <a class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light text-white" href="/admin/menus/create">
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
                      <h4 class="mt-0 header-title">Меню</h4>
                      <br><br><br>

                      <form class="needs-validation" action="/admin/menus/edit/{{$item->id}}" method="post">
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
                                            <option value="{{$category->id}}"  @if($item->parent_id==$category->id) selected @endif>{{$category->title_ru}}</option>
                                        @endif
                                        @if($category->child()->exists())
                                          @foreach($category->child as $child)
                                            <option value="{{$child->id}}" @if($item->parent_id==$child->id) selected @endif> -- {{$child->title_ru}}</option>
                                            @foreach($child->child as $ch)
                                              <option value="{{$ch->id}}" disabled> -- {{$ch->title_ru}}</option>
                                            @endforeach
                                          @endforeach
                                        @endif
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Готовые разделы для (URL)</label>
                            <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="model">
                                    <option data-select2-id="3" value="">Выберите готовые меню с подрезделами</option>
                                    <optgroup label="Законы, Постановления, Указы">
                                      <option value="LawCategory" @if($item->model=='LawCategory') selected @endif>Законы</option>
                                      @foreach(\App\Models\LawCategory::get() as $category)
                                          @if(!$category->parent()->exists())
                                            <option value="#" disabled> -- {{$category->title_ru}}</option>
                                            @foreach($category->child as $child)
                                              <option value="/laws/category/{{$category->slug}}" disabled> -- -- {{$child->title_ru}}</option>
                                              @foreach($child->laws as $laws)
                                                 <option value="/laws/{{$laws->slug}}" disabled>   -- -- -- {{$laws->title_ru}}</option>
                                              @endforeach
                                            @endforeach
                                        @endif
                                      @endforeach
                                    </optgroup>

                                    <optgroup label="Публикации, страницы">
                                      <option value="PublicationCategory" @if($item->model=='PublicationCategory') selected @endif>Публикации</option>
                                      @foreach(\App\Models\PublicationCategory::get() as $category)
                                          @if(!$category->parent()->exists())
                                            <option value="#" disabled> -- {{$category->title_ru}}</option>
                                            @foreach($category->child as $child)
                                              <option value="" disabled> -- -- {{$child->title_ru}}</option>
                                              @foreach($child->publications as $publications)
                                                 <option value="/" disabled>   -- -- -- {{$publications->title_ru}}</option>
                                              @endforeach
                                            @endforeach
                                        @endif
                                      @endforeach
                                    </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">URL</label>
                            <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="slug">
                              <option value="">Выберите страницу</option>
                              <optgroup label="Архивы новостей (Пресс-служба)">
                                  @foreach(\App\Models\Archive::get() as $category)
                                          <option value="archives/{{$category->slug}}" @if($item->slug=="archives/$category->slug") selected @endif>{{$category->title_ru}}</option>
                                          @foreach($category->news as $news)
                                             <option value="archives/item/{{$news->slug}}" @if($item->slug=="archives/item/$news->slug") selected @endif>   -- -- {{$news->title_ru}}</option>
                                          @endforeach
                                  @endforeach
                              </optgroup>

                              <optgroup label="Галлерея">
                                  <option value="photos" @if($item->slug=="photos") selected @endif>Фотогаллерея</option>
                                  <option value="videos" @if($item->slug=="videos") selected @endif>Видеогаллерея</option>
                              </optgroup>

                              <optgroup label="Наука">
                                  <option value="declaration-of-protection" @if($item->slug=="declaration-of-protection") selected @endif>Объявление о защите</option>
                              </optgroup>

                              <optgroup label="Администрация">
                                  <option value="administrations" @if($item->slug=="administrations") selected @endif>Администрация</option>
                              </optgroup>

                              <optgroup label="Структура">
                                  <option value="structure" @if($item->slug=="structure") selected @endif>Структура</option>
                              </optgroup>

                              <optgroup label="Журналы">
                                  <option value="journals" @if($item->slug=="journals") selected @endif>Журналы</option>
                              </optgroup>

                              <optgroup label="Категории страниц">
                                  @foreach(\App\Models\PageCategories::get() as $categor)
                                    <option value="pages/{{$categor->slug}}" @if($item->slug=="pages/$categor->slug") selected @endif>{{$categor->title_ru}}</option>
                                  @endforeach
                              </optgroup>

                              <optgroup label="Прочие страницы">
                                @foreach(\App\Models\Page::get() as $page)
                                  <option value="page/{{$page->slug}}" @if($item->slug=="page/$page->slug") selected @endif>{{$page->title_ru}}</option>
                                @endforeach
                              </optgroup>

                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label">Сортировка</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="sort"  type="number" min="1" value="{{$item->sort}}">
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
