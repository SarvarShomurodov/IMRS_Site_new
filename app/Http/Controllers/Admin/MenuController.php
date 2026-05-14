<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Validator;

class MenuController extends Controller
{
  public function index(){
    $items = Menu::orderBy('sort', 'DESC')->paginate(20);

    return view('admin.menus.index', compact('items'));
  }


  public function create(Request $request){
    $categories = Menu::get()->all();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/menus/create')
                      ->withErrors($validator)
                      ->withInput();
      }
      if (empty($request->slug) || $request->model) {
          $data['slug'] = '#';
      }

      Menu::create($data);

      return redirect('/admin/menus')->with('success', 'Успешно добавлено');
    }

    return view('admin.menus.create', compact('categories'));
  }


  public function edit($id, Request $request){
    $categories = Menu::get()->all();
    $item = Menu::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/menus/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }
      if (empty($request->slug) || $request->model) {
          $data['slug'] = '#';
      }

      $true = $item->update($data);
      if($true){
        return redirect('/admin/menus')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.menus.edit', compact('categories', 'item'));
  }


  public function delete($id){
    $item = Menu::find($id);

    $item->delete();
    return redirect('/admin/menus')->with('success', 'Успешно удалено');
  }
}
