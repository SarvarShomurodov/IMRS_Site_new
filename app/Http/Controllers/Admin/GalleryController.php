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
use App\Models\PhotoGallery;
use App\Models\VideoGallery;
use App\Models\HashTag;
use Validator;

class GalleryController extends Controller
{
  public function indexPhoto(){
    $items = PhotoGallery::where('status', 'gallery')->orderBy('sort', 'ASC')->paginate(20);

    return view('admin.galleries.photo.index', compact('items'));
  }


  public function createPhoto(Request $request){

    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'image'            => 'required|file|max:2048',
      ]);
      if ($validator->fails()) {
          return redirect('admin/photo-gallery/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      // ----------------------------Image upload----------------------------
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/galleries/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image"]=$file_name;
        }
      }
      $pages = PhotoGallery::create($data);

      return redirect('/admin/photo-gallery')->with('success', 'Успешно добавлено');
    }

    return view('admin.galleries.photo.create');
  }


  public function editPhoto($id, Request $request){
    $item = PhotoGallery::find($id);
    if($request->isMethod('post')){
      $data = $request->all();

      // ----------------------------Image upload----------------------------
      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/galleries/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image"]=$file_name;
            if($item->image){
              if(file_exists('images/galleries/'.$item->image)){
                unlink('images/galleries/'.$item->image);
              }
            }
        }
      }
      $item->update($data);

      return redirect('/admin/photo-gallery')->with('success', 'Успешно добавлено');
    }

    return view('admin.galleries.photo.edit', compact('item'));
  }


  public function deletePhoto($id){
    $item = PhotoGallery::find($id);

    if($item->image){
      if(file_exists('images/galleries/'.$item->image)){
        unlink('images/galleries/'.$item->image);
      }
    }

    $item->delete();
    return redirect('/admin/photo-gallery')->with('success', 'Успешно удалено');
  }


    // -----------------------------infographics-----------------------------
    public function indexInfographics(){
      $items = PhotoGallery::where('status', 'infographics')->orderBy('sort', 'ASC')->paginate(20);

      return view('admin.galleries.infographics.index', compact('items'));
    }


    public function createInfographics(Request $request){
      $hashtags = HashTag::get()->all();

      if($request->isMethod('post')){
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'image'            => 'required|file|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect('admin/infographics/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // ----------------------------Image upload----------------------------
        if($request->hasFile("image")){
          $image_tmp=$request->file("image");
          if ($image_tmp->isValid()) {
              $extension=$image_tmp->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $image_path="images/galleries/".$file_name;
              (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
              $data["image"]=$file_name;
          }
        }
        $pages = PhotoGallery::create($data);
        if(isset($request->hashtags)){
          foreach($request->hashtags as $hashtag){
            $item = HashTag::where('title', $hashtag)->get()->first();
            if($item){
              $pages->hashtags()->attach($item->id);
            }else{
              $item = new HashTag();
              $item->title = $hashtag;
              $item->save();
              $pages->hashtags()->attach($item->id);
            }
          }
        }

        return redirect('/admin/infographics')->with('success', 'Успешно добавлено');
      }

      return view('admin.galleries.infographics.create', compact('hashtags'));
    }


    public function editInfographics($id, Request $request){
      $hashtags = HashTag::get()->all();
      $item = PhotoGallery::find($id);
      if($request->isMethod('post')){
        $data = $request->all();

        // ----------------------------Image upload----------------------------
        if($request->hasFile("image")){
          $image_tmp=$request->file("image");
          if ($image_tmp->isValid()) {
              $extension=$image_tmp->getClientOriginalExtension();
              $file_name=rand(111,999999).".".$extension;
              $image_path="images/galleries/".$file_name;
              (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
              $data["image"]=$file_name;
              if($item->image){
                if(file_exists('images/galleries/'.$item->image)){
                  unlink('images/galleries/'.$item->image);
                }
              }
          }
        }
        $item->update($data);
        $item->hashtags()->detach();

        if(isset($request->hashtags)){
          foreach($request->hashtags as $hashtag){
            $hash = HashTag::where('title', $hashtag)->get()->first();
            if($hash){
              $item->hashtags()->attach($hash->id);
            }else{
              $hash = new HashTag();
              $hash->title = $hashtag;
              $hash->save();
              $item->hashtags()->attach($hash->id);
            }
          }
        }
        return redirect('/admin/infographics')->with('success', 'Успешно добавлено');
      }

      return view('admin.galleries.infographics.edit', compact('item', 'hashtags'));
    }


    public function deleteInfographics($id){
      $item = PhotoGallery::find($id);
      if($item->hashtags()->exists()){
        $item->hashtags()->detach();
      }
      if($item->image){
        if(file_exists('images/galleries/'.$item->image)){
          unlink('images/galleries/'.$item->image);
        }
      }

      $item->delete();
      return redirect('/admin/infographics')->with('success', 'Успешно удалено');
    }


  // ----------------------------------Video----------------------------------
  public function indexVideo(){
    $items = VideoGallery::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.galleries.video.index', compact('items'));
  }


  public function createVideo(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'video'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/video-gallery/create')
                      ->withErrors($validator)
                      ->withInput();
      }
      $pages = VideoGallery::create($data);

      return redirect('/admin/video-gallery')->with('success', 'Успешно добавлено');
    }

    return view('admin.galleries.video.create');
  }


  public function deleteVideo($id){
    $item = VideoGallery::find($id);

    $item->delete();
    return redirect('/admin/video-gallery')->with('success', 'Успешно удалено');
  }
}
