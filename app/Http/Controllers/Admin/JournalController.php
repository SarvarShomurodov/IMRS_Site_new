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
use App\Models\Journal;
use Validator;

class JournalController extends Controller
{
  public function index(){
    $items = Journal::orderBy('sort')->paginate(20);

    return view('admin.journals.index', compact('items'));
  }


  public function create(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'journal'             => 'required',
          'image'               => 'required',
          'time_uz'             => 'required',
          'time_ru'             => 'required',
          'time_en'             => 'required',
          'sort'                => 'nullable|integer|min:0',
      ]);
      if ($validator->fails()) {
          return redirect('admin/journals/create')
                      ->withErrors($validator)
                      ->withInput();
      }
      $data['sort'] = (int) ($data['sort'] ?? 0);
      // --------------------------------IMAGE upload--------------------------------
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/journals/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image"]=$file_name;
        }
      }

      // --------------------------------PDF WORD Upload--------------------------------
      if($request->hasFile("journal")){
        $pdf=$request->file("journal");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/journals/";
            $request->file("journal")->move($pdf_path, $file_name);
            $data["journal"]=$file_name;
        }
      }
      // dd($data);
      $pages = Journal::create($data);

      return redirect('/admin/journals')->with('success', 'Успешно добавлено');
    }

    return view('admin.journals.create');
  }


  public function edit($id, Request $request){
    $item = Journal::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
        'title_uz'            => 'required',
        'title_ru'            => 'required',
        'title_en'            => 'required',
        'time_uz'             => 'required',
        'time_ru'             => 'required',
        'time_en'             => 'required',
        'sort'                => 'nullable|integer|min:0',
      ]);
      if ($validator->fails()) {
          return redirect('admin/journals/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }
      $data['sort'] = (int) ($data['sort'] ?? 0);
      // --------------------------------IMAGE upload--------------------------------
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/journals/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image){
              if(file_exists('images/journals/'.$item->image)){
                unlink('images/journals/'.$item->image);
              }
            }
            $data["image"]=$file_name;

        }
      }

      // --------------------------------PDF WORD Upload--------------------------------
      if($request->hasFile("journal")){
        $pdf=$request->file("journal");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/journals/";
            $request->file("journal")->move($pdf_path, $file_name);
            if($item->journal){
              if(file_exists('files/journals/'.$item->journal)){
                unlink('files/journals/'.$item->journal);
              }
            }
            $data["journal"]=$file_name;
        }
      }

      $true = $item->update($data);
      if($true){
        return redirect('/admin/journals')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.journals.edit', compact('item'));
  }


  public function delete($id){
    $item = Journal::find($id);

    if($item->image){
      if(file_exists('images/journals/'.$item->image)){
        unlink('images/journals/'.$item->image);
      }
    }
    if($item->journal){
      if(file_exists('files/journals/'.$item->journal)){
        unlink('files/journals/'.$item->journal);
      }
    }

    $item->delete();
    return redirect('/admin/journals')->with('success', 'Успешно удалено');
  }
}
