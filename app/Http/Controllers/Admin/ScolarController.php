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
use App\Models\Scholar;
use App\Models\ScholarWord;
use Validator;

class ScolarController extends Controller
{
  public function index(){
    $items = Scholar::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.scholars.index', compact('items'));
  }


  public function create(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'name_uz'            => 'required',
          'name_ru'            => 'required',
          'name_en'            => 'required',
          'theme_uz'           => 'required',
          'theme_ru'           => 'required',
          'theme_en'           => 'required',
          'phddsc_uz'          => 'required',
          'phddsc_ru'          => 'required',
          'phddsc_en'          => 'required',
          'place_uz'           => 'required',
          'place_ru'           => 'required',
          'place_en'           => 'required',
          'image'              => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/scolars/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      // ----------------------------Image upload----------------------------
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/scholars/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image"]=$file_name;
        }
      }
      // Data
      $publication = Scholar::create($data);

      return redirect('/admin/scolars')->with('success', 'Успешно добавлено');
    }

    return view('admin.scholars.create');
  }


  public function edit($id, Request $request){
    $item = Scholar::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
        'name_uz'            => 'required',
        'name_ru'            => 'required',
        'name_en'            => 'required',
        'theme_uz'           => 'required',
        'theme_ru'           => 'required',
        'theme_en'           => 'required',
        'phddsc_uz'          => 'required',
        'phddsc_ru'          => 'required',
        'phddsc_en'          => 'required',
        'place_uz'           => 'required',
        'place_ru'           => 'required',
        'place_en'           => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/scolars/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }

      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/scholars/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image){
              if(file_exists('images/scholars/'.$item->image)){
                unlink('images/scholars/'.$item->image);
              }
            }
            $data["image"]=$file_name;

        }
      }

      // dd($request->all());
      $true = $item->update($data);
      if($true){
        return redirect('/admin/scolars')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.scholars.edit', compact('item'));
  }


  public function delete($id){
    $item = Scholar::find($id);
    // dd($item);
    if($item->image){
      if(file_exists('images/scholars/'.$item->image)){
        unlink('images/scholars/'.$item->image);
      }
    }
    $item->delete();
    return redirect('/admin/scolars')->with('success', 'Успешно удалено');
  }


  // --------------------------------------Word--------------------------------------
  public function indexWord(){
    $items = ScholarWord::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.scholarwords.index', compact('items'));
  }


  public function createWord(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'word'            => 'required'
      ]);
      if ($validator->fails()) {
          return redirect('admin/scolarwords/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      // ----------------------------Image upload----------------------------
      if($request->hasFile("word")){
        $word=$request->file("word");
        if ($word->isValid()) {
            $extension=$word->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $wordpath="files/scholars/";
            $request->file("word")->move($wordpath, $file_name);
            $data["word"]=$file_name;
        }
      }
      // Data
      $publication = ScholarWord::create($data);

      return redirect('/admin/scolarwords')->with('success', 'Успешно добавлено');
    }

    return view('admin.scholarwords.create');
  }


  public function deleteWord($id){
    $item = ScholarWord::find($id);
    // dd($item);
    if($item->word){
      if(file_exists('files/scholars/'.$item->word)){
        unlink('files/scholars/'.$item->word);
      }
    }
    $item->delete();
    return redirect('/admin/scolarwords')->with('success', 'Успешно удалено');
  }
}
