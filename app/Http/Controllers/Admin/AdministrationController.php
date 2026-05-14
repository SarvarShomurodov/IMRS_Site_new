<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\ArchiveRequest;
use App\Models\Administration;
use Validator;

class AdministrationController extends Controller
{
  public function index(){
    $items = Administration::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.administrations.index', compact('items'));
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
          return redirect('admin/administrations/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      // ----------------------------Image upload----------------------------
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/administrations/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image"]=$file_name;
        }
      }
      $administrations = Administration::create($data);

      return redirect('/admin/administrations')->with('success', 'Успешно добавлено');
    }

    return view('admin.administrations.create');
  }


  public function edit($id, Request $request){
    $item = Administration::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/administrations/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }

      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/administrations/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image){
              if(file_exists('images/administrations/'.$item->image)){
                unlink('images/administrations/'.$item->image);
              }
            }
            $data["image"]=$file_name;

        }
      }

      $true = $item->update($data);
      if($true){
        return redirect('/admin/administrations')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.administrations.edit', compact('item'));
  }


  public function delete($id){
    $item = Administration::find($id);

    if($item->image){
      if(file_exists('images/administrations/'.$item->image)){
        unlink('images/administrations/'.$item->image);
      }
    }
    
    $item->delete();
    return redirect('/admin/administrations')->with('success', 'Успешно удалено');
  }
}
