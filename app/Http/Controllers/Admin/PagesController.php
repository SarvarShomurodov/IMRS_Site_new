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
use App\Library\Services\PageSlug;
use App\Models\PageCategories;
use App\Models\Page;
use Validator;

class PagesController extends Controller
{
  public function index(){
    $items = Page::orderBy('created_at', 'DESC')->paginate(20);

    // dd($archives);
    // dd($archives);
    return view('admin.pages.index', compact('items'));
  }


  public function create(Request $request){
    $categories = PageCategories::all();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'slug'                => 'unique:pages',
          'meta_keywords_uz'    => 'required',
          'meta_keywords_ru'    => 'required',
          'meta_keywords_en'    => 'required',
          'meta_description_uz' => 'required',
          'meta_description_ru' => 'required',
          'meta_description_en' => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/pages/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      // ----------------------------Image upload----------------------------
      if($request->hasFile("image_uz")){
        $image_tmp=$request->file("image_uz");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/pages/uz/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_uz"]=$file_name;
        }
      }
      if($request->hasFile("image_ru")){
        $image_tmp=$request->file("image_ru");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/pages/ru/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image_ru"]=$file_name;
        }
      }
      if($request->hasFile("image_en")){
        $image_tmp=$request->file("image_en");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/pages/en/".$file_name;
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
            $pdf_path="files/pages/uz/";
            $request->file("pdf_uz")->move($pdf_path, $file_name);
            $data["pdf_uz"]=$file_name;
        }
      }
      if($request->hasFile("pdf_ru")){
        $pdf=$request->file("pdf_ru");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/pages/ru/";
            $request->file("pdf_ru")->move($pdf_path, $file_name);
            $data["pdf_ru"]=$file_name;
        }
      }
      if($request->hasFile("pdf_en")){
        $pdf=$request->file("pdf_en");
        if ($pdf->isValid()) {
            $extension=$pdf->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $pdf_path="files/pages/en/";
            $request->file("pdf_en")->move($pdf_path, $file_name);
            $data["pdf_en"]=$file_name;
        }
      }
       // -------------------------Slug-------------------------
      if (empty($request->slug)) {
          $slug = new PageSlug();
          $data['slug'] = $slug->createSlug($request->title_en);
      }
      // dd($data);
      $pages = Page::create($data);
      if($request->category){
        foreach($request->category as $category){
          $pages->categories()->attach($category);
        }
      }
      return redirect('/admin/pages')->with('success', 'Успешно добавлено');
    }

    return view('admin.pages.create', compact('categories'));
  }


  public function edit($id, Request $request){
    $item = Page::find($id);
    $categories = PageCategories::all();
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
          return redirect('admin/pages/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }

      if($request->hasFile("image_uz")){
        $image_tmp=$request->file("image_uz");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/pages/uz/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_uz){
              if(file_exists('images/pages/uz/'.$item->image_uz)){
                unlink('images/pages/uz/'.$item->image_uz);
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
            $image_path="images/pages/ru/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_ru){
              if(file_exists('images/pages/ru/'.$item->image_ru)){
                unlink('images/pages/ru/'.$item->image_ru);
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
            $image_path="images/pages/en/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image_en){
              if(file_exists('images/pages/en/'.$item->image_en)){
                unlink('images/pages/en/'.$item->image_en);
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
            $pdf_path="files/pages/uz/";
            $request->file("pdf_uz")->move($pdf_path, $file_name);
              if($item->pdf_uz){
              if(file_exists('files/pages/uz/'.$item->pdf_uz)){
                unlink('files/pages/uz/'.$item->pdf_uz);
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
            $pdf_path="files/pages/ru/";
            $request->file("pdf_ru")->move($pdf_path, $file_name);
              if($item->pdf_ru){
              if(file_exists('files/pages/ru/'.$item->pdf_ru)){
                unlink('files/pages/ru/'.$item->pdf_ru);
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
            $pdf_path="files/pages/en/";
            $request->file("pdf_en")->move($pdf_path, $file_name);
              if($item->pdf_en){
              if(file_exists('files/pages/en/'.$item->pdf_en)){
                unlink('files/pages/en/'.$item->pdf_en);
              }
            }
            $data["pdf_en"]=$file_name;
        }
      }

      $item->categories()->detach();
      if($request->category){
        foreach($request->category as $category){
          $item->categories()->attach($category);
        }
      }

      // dd($request->all());
      $true = $item->update($data);
      if($true){
        return redirect('/admin/pages')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.pages.edit', compact('item', 'categories'));
  }


  public function delete($id){
    $item = Page::find($id);

    if($item->image_uz){
      if(file_exists('images/pages/uz/'.$item->image_uz)){
        unlink('images/pages/uz/'.$item->image_uz);
      }
    }
    if($item->image_ru){
      if(file_exists('images/pages/ru/'.$item->image_ru)){
        unlink('images/pages/ru/'.$item->image_ru);
      }
    }
    if($item->image_en){
      if(file_exists('images/pages/en/'.$item->image_en)){
        unlink('images/pages/en/'.$item->image_en);
      }
    }


    if($item->pdf_uz){
      if(file_exists('files/pages/uz/'.$item->pdf_uz)){
        unlink('files/pages/uz/'.$item->pdf_uz);
      }
    }
    if($item->pdf_ru){
      if(file_exists('files/pages/ru/'.$item->pdf_ru)){
        unlink('files/pages/ru/'.$item->pdf_ru);
      }
    }
    if($item->pdf_en){
      if(file_exists('files/pages/en/'.$item->pdf_en)){
        unlink('files/pages/en/'.$item->pdf_en);
      }
    }
    $item->categories()->detach();
    $item->delete();
    return redirect('/admin/pages')->with('success', 'Успешно удалено');
  }




  // --------------------------------Categories--------------------------------
  public function indexCategory(){
    $items = PageCategories::orderBy('created_at', 'DESC')->paginate(20);

    // dd($archives);
    // dd($archives);
    return view('admin.pagecategories.index', compact('items'));
  }


  public function createCategory(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'slug'                => 'unique:page_categories',
      ]);
      if ($validator->fails()) {
          return redirect('admin/pages-categories/create')
                      ->withErrors($validator)
                      ->withInput();
      }


       // -------------------------Slug-------------------------
      if (empty($request->slug)) {
          $slug = new PageSlug();
          $data['slug'] = $slug->createSlug($request->title_en);
      }
      // dd($data);
      $pages = PageCategories::create($data);

      return redirect('/admin/pages-categories')->with('success', 'Успешно добавлено');
    }

    return view('admin.pagecategories.create');
  }


  public function editCategory($id, Request $request){
    $item = PageCategories::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'title_uz'            => 'required',
          'title_ru'            => 'required',
          'title_en'            => 'required',
          'slug'                => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/pages-categories/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }


      // dd($request->all());
      $true = $item->update($data);
      if($true){
        return redirect('/admin/pages-categories')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.pagecategories.edit', compact('archives', 'item'));
  }


  public function deleteCategory($id){
    $item = PageCategories::find($id);
    if($item->pages()->exists()){
      return redirect('admin/pages-categories/')
                  ->withErrors(['message'=>'Невозможно удалить, категория привязан страницу'])
                  ->withInput();
    }
    $item->delete();
    return redirect('/admin/pages-categories')->with('success', 'Успешно удалено');
  }
}
