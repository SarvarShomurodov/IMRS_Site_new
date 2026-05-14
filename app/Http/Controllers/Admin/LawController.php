<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\SlugServiceProvider;
use App\Library\Services\LawCategorySlug;
use App\Models\LawCategory;
use App\Models\Law;
use Validator;

class LawController extends Controller
{
  public function indexCategory(){
    $items = LawCategory::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.lawscategories.index', compact('items'));
  }


  public function createCategory(Request $request){
    $categories = LawCategory::get()->all();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'slug'                => 'unique:law_categories',
      ]);
      if ($validator->fails()) {
          return redirect('admin/laws-categories/create')
                      ->withErrors($validator)
                      ->withInput();
      }
      if (empty($request->slug)) {
          $slug = new LawCategorySlug();
          $data['slug'] = $slug->createSlug($request->title_en);
      }
      $archive = LawCategory::create($data);
      return redirect('/admin/laws-categories')->with('success', 'Успешно добавлено');
    }

    return view('admin.lawscategories.create', compact('categories'));
  }


  public function editCategory($id, Request $request){
    $item = LawCategory::find($id);
    $categories = LawCategory::get()->all();
    if($request->isMethod('post')){
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'slug'                => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/laws-categories/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }
      if($item->child()->exists() && $request->parent_id>0){
          return redirect('admin/laws-categories/edit/'.$id)
                      ->withErrors(['error_message'=>'Нельзя изменить родительского раздела '])
                      ->withInput();
      }
      $true = $item->update($request->all());
      if($true){
        return redirect('/admin/laws-categories')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.lawscategories.edit', compact('item', 'categories'));
  }


  public function deleteCategory($id){
    $item = LawCategory::find($id);
    if($item->child()->exists()){
      return redirect('admin/laws-categories/')
                  ->withErrors(['message'=>'Невозможно удалить, раздел имеет подрездела'])
                  ->withInput();
    }
    if($item->laws()->exists()){
      return redirect('admin/laws-categories/')
                  ->withErrors(['message'=>'Невозможно удалить, раздел прикреплен законам'])
                  ->withInput();
    }
    $item->delete();
    return redirect('/admin/laws-categories')->with('success', 'Успешно удалено');
  }


  // ---------------------------------------------------------NEWS---------------------------------------------------------
  public function index(){
    $items = Law::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.laws.index', compact('items'));
  }


  public function create(Request $request){
    $categories = LawCategory::orderBy('created_at', 'DESC')->get();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'category_id'         => 'required',
          'slug_uz'             => 'required',
          'slug_ru'             => 'required',
          'slug_en'             => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/laws/create')
                      ->withErrors($validator)
                      ->withInput();
      }


      Law::create($data);

      return redirect('/admin/laws')->with('success', 'Успешно добавлено');
    }

    return view('admin.laws.create', compact('categories'));
  }


  public function edit($id, Request $request){
    $categories = LawCategory::get();
    $item = Law::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'category_id'         => 'required',
          'slug_uz'             => 'required',
          'slug_ru'             => 'required',
          'slug_en'             => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/laws/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }

      $true = $item->update($data);
      if($true){
        return redirect('/admin/laws')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.laws.edit', compact('categories', 'item'));
  }


  public function delete($id){
    $item = Law::find($id);

    $item->delete();
    return redirect('/admin/laws')->with('success', 'Успешно удалено');
  }
}
