<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Structure;
use Validator;

class StructureController extends Controller
{
  public function index(){
    $items = Structure::orderBy('sort', 'DESC')->paginate(20);

    return view('admin.structure.index', compact('items'));
  }


  public function create(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/structure/create')
                      ->withErrors($validator)
                      ->withInput();
      }


      Structure::create($data);
      return redirect('/admin/structure')->with('success', 'Успешно добавлено');
    }
    return view('admin.structure.create');
  }


  public function edit($id, Request $request){
    $item = Structure::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/structure/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }

      $true = $item->update($data);
      if($true){
        return redirect('/admin/structure')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.structure.edit', compact('item'));
  }


  public function delete($id){
    $item = Structure::find($id);

    $item->delete();
    return redirect('/admin/structure')->with('success', 'Успешно удалено');
  }
}
