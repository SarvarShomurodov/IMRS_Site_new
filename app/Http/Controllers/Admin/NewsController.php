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
use App\Providers\SlugServiceProvider;
use App\Library\Services\ArchiveSlug;
use App\Library\Services\NewsSlug;
use App\Models\Archive;
use App\Models\News;
use App\Models\File as Filepdf;
use Validator;

class NewsController extends Controller
{
    public function indexArchive(){
      $archives = Archive::orderBy('created_at', 'DESC')->paginate(20);

      // dd($archives);
      // dd($archives);
      return view('admin.archives.index', compact('archives'));
    }


    public function createArchive(Request $request){
      if($request->isMethod('post')){
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title_uz'            => 'required',
            'title_ru'            => 'required',
            'title_en'            => 'required',
            'slug'                => 'unique:archives',
            'meta_keywords_uz'    => 'required',
            'meta_keywords_ru'    => 'required',
            'meta_keywords_en'    => 'required',
            'meta_description_uz' => 'required',
            'meta_description_ru' => 'required',
            'meta_description_en' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/archives/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        if (empty($request->slug)) {
            $slug = new ArchiveSlug();
            $data['slug'] = $slug->createSlug($request->title_en);
        }
        $archive = Archive::create($data);
        return redirect('/admin/archives')->with('success', 'Успешно добавлено');
      }

      return view('admin.archives.create');
    }


    public function editArchive($id, Request $request){
      $archive = Archive::find($id);
      if($request->isMethod('post')){
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
            return redirect('admin/archives/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        $true = $archive->update($request->all());
        if($true){
          return redirect('/admin/archives')->with('success', 'Успешно Изменено');
        }

      }

      return view('admin.archives.edit', compact('archive'));
    }


    public function deleteArchive($id){
      $item = Archive::find($id);
      if($item->news()->exists()){
        return redirect('admin/archives/')
                    ->withErrors(['message'=>'Невозможно удалить, архив привязан новостям'])
                    ->withInput();
      }
      $item->delete();
      return redirect('/admin/archives')->with('success', 'Успешно удалено');
    }


    // ---------------------------------------------------------NEWS---------------------------------------------------------
    public function index(){
      $items = News::orderBy('created_at', 'DESC')->paginate(20);

      // dd($archives);
      // dd($archives);
      return view('admin.news.index', compact('items'));
    }


    public function create(Request $request){
      $archives = Archive::orderBy('created_at', 'DESC')->get();
      if($request->isMethod('post')){
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title_uz'            => 'required',
            'title_ru'            => 'required',
            'title_en'            => 'required',
            'category'            => 'required',
            'slug'                => 'unique:news',
            'meta_keywords_uz'    => 'required',
            'meta_keywords_ru'    => 'required',
            'meta_keywords_en'    => 'required',
            'meta_description_uz' => 'required',
            'meta_description_ru' => 'required',
            'meta_description_en' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/news/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // ----------------------------Image upload----------------------------
        if($request->hasFile("image_uz")){
          $image_tmp=$request->file("image_uz");
          if ($image_tmp->isValid()) {
              $extension=$image_tmp->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $image_path="images/news/uz/".$file_name;
              (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
              $data["image_uz"]=$file_name;
          }
        }
        if($request->hasFile("image_ru")){
          $image_tmp=$request->file("image_ru");
          if ($image_tmp->isValid()) {
              $extension=$image_tmp->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $image_path="images/news/ru/".$file_name;
              (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
              $data["image_ru"]=$file_name;
          }
        }
        if($request->hasFile("image_en")){
          $image_tmp=$request->file("image_en");
          if ($image_tmp->isValid()) {
              $extension=$image_tmp->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $image_path="images/news/en/".$file_name;
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
              $pdf_path="files/news/uz/";
              $request->file("pdf_uz")->move($pdf_path, $file_name);
              $data["pdf_uz"]=$file_name;
          }
        }
        if($request->hasFile("pdf_ru")){
          $pdf=$request->file("pdf_ru");
          if ($pdf->isValid()) {
              $extension=$pdf->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $pdf_path="files/news/ru/";
              $request->file("pdf_ru")->move($pdf_path, $file_name);
              $data["pdf_ru"]=$file_name;
          }
        }
        if($request->hasFile("pdf_en")){
          $pdf=$request->file("pdf_en");
          if ($pdf->isValid()) {
              $extension=$pdf->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $pdf_path="files/news/en/";
              $request->file("pdf_en")->move($pdf_path, $file_name);
              $data["pdf_en"]=$file_name;
          }
        }
         // -------------------------Slug-------------------------
        if (empty($request->slug)) {
            $slug = new NewsSlug();
            $data['slug'] = $slug->createSlug($request->title_en);
        }
        if (empty($request->created_at)) {
            $data['created_at'] = now();
        }
        // dd($data);
        $news = News::create($data);
        foreach($request->category as $category){
          $news->categories()->attach($category);
        }
        if($request->pdf){
          for($i=1; $i<=count($request->pdf); $i++){
            if($request->hasFile("pdf.$i")){
              $pdf=$request->file("pdf.$i");
              if ($pdf->isValid()) {
                  $extension=$pdf->getClientOriginalExtension();
                  $file_name="news_".rand(111,999999).".".$extension;
                  $pdf_path="files/files/";
                  $request->file("pdf.$i")->move($pdf_path, $file_name);
                  $file = Filepdf::create(['file'=>$file_name]);
                  $news->files()->attach($file->id);
              }
            }
          }
        }
        return redirect('/admin/news')->with('success', 'Успешно добавлено');
      }

      return view('admin.news.create', compact('archives'));
    }


    public function edit($id, Request $request){
      $archives = Archive::get();
      $item = News::find($id);
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
            return redirect('admin/news/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->hasFile("image_uz")){
          $image_tmp=$request->file("image_uz");
          if ($image_tmp->isValid()) {
              $extension=$image_tmp->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $image_path="images/news/uz/".$file_name;
              (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
              if($item->image_uz){
                if(file_exists('images/news/uz/'.$item->image_uz)){
                  unlink('images/news/uz/'.$item->image_uz);
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
              $image_path="images/news/ru/".$file_name;
              (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
              if($item->image_ru){
                if(file_exists('images/news/ru/'.$item->image_ru)){
                  unlink('images/news/ru/'.$item->image_ru);
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
              $image_path="images/news/en/".$file_name;
              (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
              if($item->image_en){
                if(file_exists('images/news/en/'.$item->image_en)){
                  unlink('images/news/en/'.$item->image_en);
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
              $pdf_path="files/news/uz/";
              $request->file("pdf_uz")->move($pdf_path, $file_name);
                if($item->pdf_uz){
                if(file_exists('files/news/uz/'.$item->pdf_uz)){
                  unlink('files/news/uz/'.$item->pdf_uz);
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
              $pdf_path="files/news/ru/";
              $request->file("pdf_ru")->move($pdf_path, $file_name);
                if($item->pdf_ru){
                if(file_exists('files/news/ru/'.$item->pdf_ru)){
                  unlink('files/news/ru/'.$item->pdf_ru);
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
              $pdf_path="files/news/en/";
              $request->file("pdf_en")->move($pdf_path, $file_name);
                if($item->pdf_en){
                if(file_exists('files/news/en/'.$item->pdf_en)){
                  unlink('files/news/en/'.$item->pdf_en);
                }
              }
              $data["pdf_en"]=$file_name;
          }
        }


        // dd($request->all());
        $true = $item->update($data);
        $item->categories()->detach();
        if($request->pdf){
          for($i=1; $i<=count($request->pdf); $i++){
            if($request->hasFile("pdf.$i")){
              $pdf=$request->file("pdf.$i");
              if ($pdf->isValid()) {
                  $extension=$pdf->getClientOriginalExtension();
                  $file_name="news_".rand(111,999999).".".$extension;
                  $pdf_path="files/files/";
                  $request->file("pdf.$i")->move($pdf_path, $file_name);
                  $file = Filepdf::create(['file'=>$file_name]);
                  $item->files()->attach($file->id);
              }
            }
          }
        }
        foreach($request->category as $category){
          $item->categories()->attach($category);
        }
        if($true){
          return redirect('/admin/news')->with('success', 'Успешно Изменено');
        }

      }

      return view('admin.news.edit', compact('archives', 'item'));
    }


    public function delete($id){
      $item = News::find($id);

      if($item->image_uz){
        if(file_exists('images/news/uz/'.$item->image_uz)){
          unlink('images/news/uz/'.$item->image_uz);
        }
      }
      if($item->image_ru){
        if(file_exists('images/news/ru/'.$item->image_ru)){
          unlink('images/news/ru/'.$item->image_ru);
        }
      }
      if($item->image_en){
        if(file_exists('images/news/en/'.$item->image_en)){
          unlink('images/news/en/'.$item->image_en);
        }
      }


      if($item->pdf_uz){
        if(file_exists('files/news/uz/'.$item->pdf_uz)){
          unlink('files/news/uz/'.$item->pdf_uz);
        }
      }
      if($item->pdf_ru){
        if(file_exists('files/news/ru/'.$item->pdf_ru)){
          unlink('files/news/ru/'.$item->pdf_ru);
        }
      }
      if($item->pdf_en){
        if(file_exists('files/news/en/'.$item->pdf_en)){
          unlink('files/news/en/'.$item->pdf_en);
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
      return redirect('/admin/news')->with('success', 'Успешно удалено');
    }
}
