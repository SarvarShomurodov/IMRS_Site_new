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
use App\Models\Slider;
use Validator;

class SliderController extends Controller
{
  public function index(){
    $items = Slider::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.sliders.index', compact('items'));
  }


  public function create(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'image_uz'            => 'required',
          'image_ru'            => 'required',
          'image_en'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/sliders/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      // ----------------------------Image upload----------------------------
      if($request->hasFile("image_uz")){
        $image_tmp=$request->file("image_uz");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/sliders/uz/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_uz"]=$file_name;
        }
      }
      if($request->hasFile("image_ru")){
        $image_tmp=$request->file("image_ru");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/sliders/ru/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_ru"]=$file_name;
        }
      }
      if($request->hasFile("image_en")){
        $image_tmp=$request->file("image_en");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/sliders/en/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_en"]=$file_name;
        }
      }
      // if($data["status"]=='active'){
      //   $data["status"]=='active';
      // }else{
      //   $data["status"]=='inactive';
      // }

      // dd($data);
      $pages = Slider::create($data);

      return redirect('/admin/sliders')->with('success', 'Успешно добавлено');
    }

    return view('admin.sliders.create');
  }


  public function edit($id, Request $request){
    $item = Slider::find($id);
    if($request->isMethod('post')){
      $data = $request->all();

      if($request->hasFile("image_uz")){
        $image_tmp=$request->file("image_uz");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/sliders/uz/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_uz){
              if(file_exists('images/sliders/uz/'.$item->image_uz)){
                unlink('images/sliders/uz/'.$item->image_uz);
              }
            }
            $data["image_uz"]=$file_name;

        }
      }
      if($request->hasFile("image_ru")){
        $image_tmp=$request->file("image_ru");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/sliders/ru/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_ru){
              if(file_exists('images/sliders/ru/'.$item->image_ru)){
                unlink('images/sliders/ru/'.$item->image_ru);
              }
            }
            $data["image_ru"]=$file_name;
        }
      }
      if($request->hasFile("image_en")){
        $image_tmp=$request->file("image_en");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/sliders/en/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_en){
              if(file_exists('images/sliders/en/'.$item->image_en)){
                unlink('images/sliders/en/'.$item->image_en);
              }
            }
            $data["image_en"]=$file_name;
        }
      }
      // if($data["status"]=='active'){
      //   $data["status"]=='active';
      // }else{
      //   $data["status"]=='inactive';
      // }

      $true = $item->update($data);
      if($true){
        return redirect('/admin/sliders')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.sliders.edit', compact('archives', 'item'));
  }


  public function delete($id){
    $item = Slider::find($id);

    if($item->image_uz){
      if(file_exists('images/sliders/uz/'.$item->image_uz)){
        unlink('images/sliders/uz/'.$item->image_uz);
      }
    }
    if($item->image_ru){
      if(file_exists('images/sliders/ru/'.$item->image_ru)){
        unlink('images/sliders/ru/'.$item->image_ru);
      }
    }
    if($item->image_en){
      if(file_exists('images/sliders/en/'.$item->image_en)){
        unlink('images/sliders/en/'.$item->image_en);
      }
    }

    $item->delete();
    return redirect('/admin/sliders')->with('success', 'Успешно удалено');
  }
}
