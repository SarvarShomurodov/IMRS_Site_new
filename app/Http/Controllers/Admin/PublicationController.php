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
use App\Providers\SlugServiceProvider;
use App\Library\Services\PublicationCategorySlug;
use App\Library\Services\PublicationSlug;
use App\Models\PublicationCategory;
use App\Models\Publication;
use App\Models\File as Filepdf;
use Validator;

class PublicationController extends Controller
{
  public function indexCategories(){
    $items = PublicationCategory::with('child')->orderBy('created_at', 'DESC')->paginate(20);

    // dd($archives);
    // dd($archives);
    return view('admin.publicationcategories.index', compact('items'));
  }


  public function createCategories(Request $request){
    $categories = PublicationCategory::get()->all();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'slug'                => 'unique:publication_categories',
          'meta_keywords_uz'    => 'required',
          'meta_keywords_ru'    => 'required',
          'meta_keywords_en'    => 'required',
          'meta_description_uz' => 'required',
          'meta_description_ru' => 'required',
          'meta_description_en' => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/publications/categories/create')
                      ->withErrors($validator)
                      ->withInput();
      }
      if (empty($request->slug)) {
          $slug = new PublicationCategorySlug();
          $data['slug'] = $slug->createSlug($request->title_en);
      }
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/publicationcategories/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image"]=$file_name;
        }
      }
      $archive = PublicationCategory::create($data);
      return redirect('/admin/publications/categories')->with('success', 'Успешно добавлено');
    }

    return view('admin.publicationcategories.create', compact('categories'));
  }


  public function editCategories($id, Request $request){
    $item = PublicationCategory::find($id);
    $categories = PublicationCategory::get()->all();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'slug'                => 'required',
          'meta_keywords_uz'    => 'required',
          'meta_keywords_ru'    => 'required',
          'meta_keywords_en'    => 'required',
          'meta_description_uz' => 'required',
          'meta_description_ru' => 'required',
          'meta_description_en' => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/publications/categories/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/publicationcategories/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image){
              if(file_exists('images/publicationcategories/'.$item->image)){
                unlink('images/publicationcategories/'.$item->image);
              }
            }
            $data["image"]=$file_name;
        }
      }
      $true = $item->update($data);
      if($true){
        return redirect('/admin/publications/categories')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.publicationcategories.edit', compact('item', 'categories'));
  }


  public function deleteCategories ($id){
    $item = PublicationCategory::find($id);
    if($item->child()->exists()){
      return redirect('admin/publications/categories/')
                  ->withErrors(['message'=>'Невозможно удалить, категория является родительским категорием'])
                  ->withInput();
    }
    if($item->publications()->exists()){
      return redirect('admin/publications/categories/')
                  ->withErrors(['message'=>'Невозможно удалить, категория привязан публикацию'])
                  ->withInput();
    }
    if($item->image){
      if(file_exists('images/publicationcategories/'.$item->image)){
        unlink('images/publicationcategories/'.$item->image);
      }
    }
    $item->delete();
    return redirect('/admin/publications/categories')->with('success', 'Успешно удалено');
  }


  // ---------------------------------------------------------Publications---------------------------------------------------------
  public function index(){
    $items = Publication::orderBy('created_at', 'DESC')->paginate(20);

    // dd($archives);
    // dd($archives);
    return view('admin.publications.index', compact('items'));
  }


  public function create(Request $request){
    $categories = PublicationCategory::orderBy('created_at', 'DESC')->get();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'category'            => 'required',
          'slug'                => 'unique:publications',
          'meta_keywords_uz'    => 'required',
          'meta_keywords_ru'    => 'required',
          'meta_keywords_en'    => 'required',
          'meta_description_uz' => 'required',
          'meta_description_ru' => 'required',
          'meta_description_en' => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/publications/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      // ----------------------------Image upload----------------------------
      if($request->hasFile("image_uz")){
        $image_tmp=$request->file("image_uz");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/publications/uz/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_uz"]=$file_name;
        }
      }
      if($request->hasFile("image_ru")){
        $image_tmp=$request->file("image_ru");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/publications/ru/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_ru"]=$file_name;
        }
      }
      if($request->hasFile("image_en")){
        $image_tmp=$request->file("image_en");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/publications/en/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_en"]=$file_name;
        }
      }

      // --------------------------------PDF WORD Upload--------------------------------
      if($request->hasFile("pdf_uz")){
        $pdf=$request->file("pdf_uz");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/publications/uz/";
            $request->file("pdf_uz")->move($pdf_path, $file_name);
            $data["pdf_uz"]=$file_name;
        }
      }
      if($request->hasFile("pdf_ru")){
        $pdf=$request->file("pdf_ru");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/publications/ru/";
            $request->file("pdf_ru")->move($pdf_path, $file_name);
            $data["pdf_ru"]=$file_name;
        }
      }
      if($request->hasFile("pdf_en")){
        $pdf=$request->file("pdf_en");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/publications/en/";
            $request->file("pdf_en")->move($pdf_path, $file_name);
            $data["pdf_en"]=$file_name;
        }
      }
       // -------------------------Slug-------------------------
      if (empty($request->slug)) {
          $slug = new PublicationSlug();
          $data['slug'] = $slug->createSlug($request->title_en);
      }
      if (empty($request->created_at)) {
            $data['created_at'] = now();
        }
      // dd($data);
      $publication = Publication::create($data);
      foreach($request->category as $category){
        $publication->categories()->attach($category);
      }
      if($request->pdf){
        for($i=1; $i<=count($request->pdf); $i++){
          if($request->hasFile("pdf.$i")){
            $pdf=$request->file("pdf.$i");
            if ($pdf->isValid()) {
                $extension=$pdf->getClientOriginalExtension();
                $file_name="publications_".rand(111,999999).".".$extension;
                $pdf_path="files/files/";
                $request->file("pdf.$i")->move($pdf_path, $file_name);
                $file = Filepdf::create(['file'=>$file_name]);
                $publication->files()->attach($file->id);
            }
          }
        }
      }

      return redirect('/admin/publications')->with('success', 'Успешно добавлено');
    }

    return view('admin.publications.create', compact('categories'));
  }


  public function edit($id, Request $request){
    $categories = PublicationCategory::get();
    $item = Publication::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'created_at'          => 'required',
          'category'            => 'required',
          'slug'                => 'required',
          'meta_keywords_uz'    => 'required',
          'meta_keywords_ru'    => 'required',
          'meta_keywords_en'    => 'required',
          'meta_description_uz' => 'required',
          'meta_description_ru' => 'required',
          'meta_description_en' => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/publications/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }

      if($request->hasFile("image_uz")){
        $image_tmp=$request->file("image_uz");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/publications/uz/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_uz){
              if(file_exists('images/publications/uz'.$item->image_uz)){
                unlink('images/publications/uz/'.$item->image_uz);
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
            $image_path="images/publications/ru/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_ru){
              if(file_exists('images/publications/ru/'.$item->image_ru)){
                unlink('images/publications/ru/'.$item->image_ru);
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
            $image_path="images/publications/en/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_en){
              if(file_exists('images/publications/en/'.$item->image_en)){
                unlink('images/publications/en/'.$item->image_en);
              }
            }
            $data["image_en"]=$file_name;
        }
      }

      // --------------------------------PDF WORD Upload--------------------------------
      if($request->hasFile("pdf_uz")){
        $pdf=$request->file("pdf_uz");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/publications/uz/";
            $request->file("pdf_uz")->move($pdf_path, $file_name);
            if($item->pdf_uz){
              if(file_exists('files/publications/uz/'.$item->pdf_uz)){
                unlink('files/publications/uz/'.$item->pdf_uz);
              }
            }
            $data["pdf_uz"]=$file_name;
        }
      }
      if($request->hasFile("pdf_ru")){
        $pdf=$request->file("pdf_ru");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/publications/ru/";
            $request->file("pdf_ru")->move($pdf_path, $file_name);
            if($item->pdf_ru){
              if(file_exists('files/publications/ru/'.$item->pdf_ru)){
                unlink('files/publications/ru/'.$item->pdf_ru);
              }
            }
            $data["pdf_ru"]=$file_name;
        }
      }
      if($request->hasFile("pdf_en")){
        $pdf=$request->file("pdf_en");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/publications/en/";
            $request->file("pdf_en")->move($pdf_path, $file_name);
            if($item->pdf_en){
              if(file_exists('files/publications/en/'.$item->pdf_en)){
                unlink('files/publications/en/'.$item->pdf_en);
              }
            }
            $data["pdf_en"]=$file_name;
        }
      }


      // dd($request->all());
      $true = $item->update($data);
      $item->categories()->detach();
      foreach($request->category as $category){
        $item->categories()->attach($category);
      }
      if($request->pdf){
        for($i=1; $i<=count($request->pdf); $i++){
          if($request->hasFile("pdf.$i")){
            $pdf=$request->file("pdf.$i");
            if ($pdf->isValid()) {
                $extension=$pdf->getClientOriginalExtension();
                $file_name="publications_".rand(111,999999).".".$extension;
                $pdf_path="files/files/";
                $request->file("pdf.$i")->move($pdf_path, $file_name);
                $file = Filepdf::create(['file'=>$file_name]);
                $item->files()->attach($file->id);
            }
          }
        }
      }

      if($true){
        return redirect('/admin/publications')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.publications.edit', compact('categories', 'item'));
  }


  public function delete($id){
    $item = Publication::find($id);
    // dd($item);
    if($item->image_uz){
      if(file_exists('images/publications/uz/'.$item->image_uz)){
        unlink('images/publications/uz/'.$item->image_uz);
      }
    }
    if($item->image_ru){
      if(file_exists('images/publications/ru/'.$item->image_ru)){
        unlink('images/publications/ru/'.$item->image_ru);
      }
    }
    if($item->image_en){
      if(file_exists('images/publications/en/'.$item->image_en)){
        unlink('images/publications/en/'.$item->image_en);
      }
    }
    if($item->pdf_uz){
      if(file_exists('files/publications/uz/'.$item->pdf_uz)){
        unlink('files/publications/uz/'.$item->pdf_uz);
      }
    }
    if($item->pdf_ru){
      if(file_exists('files/publications/ru/'.$item->pdf_ru)){
        unlink('files/publications/ru/'.$item->pdf_ru);
      }
    }
    if($item->pdf_en){
      if(file_exists('files/publications/en/'.$item->pdf_en)){
        unlink('files/publications/en/'.$item->pdf_en);
      }
    }

    if($item->files()->exists()){
      foreach($item->files as $file){
        if($file->file){
          if(file_exists('files/files/'.$file->file)){
            unlink('files/files/'.$file->file);
          }
        }
        $item->files()->detach($file->id);
        $file->delete();
      }
    }

    $item->categories()->detach();
    $item->delete();
    return redirect('/admin/publications')->with('success', 'Успешно удалено');
  }
}
