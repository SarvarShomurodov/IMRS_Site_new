<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\News;
use App\Models\Publication;
use App\Models\Page;

class FilesController extends Controller
{
  public function delete($type, $id, $id1){
    if($type=='news'){
      $news = News::find($id);
      $news->files()->detach($id1);
      $file = File::find($id1);
      if($file->file){
        if(file_exists('files/files/'.$file->file)){
          unlink('files/files/'.$file->file);
        }
      }
      $file->delete();
      return redirect('admin/news/edit/'.$id)->with('success', 'Успешно удалено');
    }elseif($type=='publications'){
      $news = Publication::find($id);
      $news->files()->detach($id1);
      $file = File::find($id1);
      if($file->file){
        if(file_exists('files/files/'.$file->file)){
          unlink('files/files/'.$file->file);
        }
      }
      $file->delete();
      return redirect('admin/publications/edit/'.$id)->with('success', 'Успешно удалено');
    }
  }
}
