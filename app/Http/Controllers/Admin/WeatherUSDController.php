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
use App\Models\WeatherUSD;
use App\Models\Weather;
use Validator;

class WeatherUSDController extends Controller
{
  public function index(){
    $items = WeatherUSD::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.weathers.index', compact('items'));
  }


  public function create(Request $request){
    $weathers = Weather::get();
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'weather_from'            => 'required',
          'weather_to'              => 'required',
          'weather_id'              => 'required',
          'usd_from'                => 'required',
          'usd_to'                  => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/weathers/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      $archive = WeatherUSD::create($data);
      return redirect('/admin/weathers')->with('success', 'Успешно добавлено');
    }

    return view('admin.weathers.create', compact('weathers'));
  }


  public function edit($id, Request $request){
    $weathers = Weather::get();
    $item = WeatherUSD::find($id);
    if($request->isMethod('post')){
      $validator = Validator::make($request->all(), [
        'weather_from'            => 'required',
        'weather_to'              => 'required',
        'weather_id'              => 'required',
        'usd_from'                => 'required',
        'usd_to'                  => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/weathers/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }
      $true = $item->update($request->all());
      if($true){
        return redirect('/admin/weathers')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.weathers.edit', compact('item', 'weathers'));
  }


  public function delete($id){
    $item = WeatherUSD::find($id);
    $item->delete();
    return redirect('/admin/weathers')->with('success', 'Успешно удалено');
  }


  // ---------------------------------Weather---------------------------------
  public function indexWeather(){
    $items = Weather::orderBy('created_at', 'DESC')->paginate(20);

    return view('admin.weather.index', compact('items'));
  }


  public function createWeather(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
          'image'                  => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/weather/create')
                      ->withErrors($validator)
                      ->withInput();
      }

      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/weathers/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            $data["image"]=$file_name;
        }
      }

      $archive = Weather::create($data);
      return redirect('/admin/weather')->with('success', 'Успешно добавлено');
    }

    return view('admin.weather.create');
  }


  public function editWeather($id, Request $request){
    $item = Weather::find($id);
    if($request->isMethod('post')){
      $data = $request->all();
      $validator = Validator::make($request->all(), [
        'image'            => 'required',
      ]);
      if ($validator->fails()) {
          return redirect('admin/weather/edit/'.$id)
                      ->withErrors($validator)
                      ->withInput();
      }

      if($request->hasFile("image")){
        $image_tmp=$request->file("image");
        if ($image_tmp->isValid()) {
            $extension=$image_tmp->getClientOriginalExtension();
            $file_name=rand(111,999999).".".$extension;
            $image_path="images/weathers/".$file_name;
            (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);
            if($item->image){
              if(file_exists('images/weathers/'.$item->image)){
                unlink('images/weathers/'.$item->image);
              }
            }
            $data["image"]=$file_name;
        }
      }

      $true = $item->update($data);
      if($true){
        return redirect('/admin/weather')->with('success', 'Успешно Изменено');
      }

    }

    return view('admin.weather.edit', compact('item'));
  }


  public function deleteWeather($id){
    $item = Weather::find($id);
    if($item->child()->exists()){
          return redirect('admin/weather')
                      ->withErrors(['message'=>'Невозможно удалить так как иконка на данный момент показывается на сайте'])
                      ->withInput();
      }
    if($item->image){
      if(file_exists('images/weathers/'.$item->image)){
        unlink('images/weathers/'.$item->image);
      }
    }

    $item->delete();
    return redirect('/admin/weather')->with('success', 'Успешно удалено');
  }

}
