<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\PageHero;
use Validator;

class PageHeroController extends Controller
{
    protected $dir = 'images/page-heroes';

    public function index()
    {
        $items = PageHero::orderBy('id', 'ASC')->get();
        return view('admin.page-heroes.index', compact('items'));
    }

    public function update($id, Request $request)
    {
        $item = PageHero::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:30720',
            'video'    => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:61440', // 60 MB (PHP limiti ~64M)
            'position' => 'nullable|in:top,center,bottom',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/page-heroes')
                ->withErrors($validator)
                ->with('error', 'Ошибка: проверьте загружаемый файл.');
        }

        // Видео-фон (mp4/webm/ogg)
        if ($request->hasFile('video')) {
            $video_tmp = $request->file('video');
            if ($video_tmp->isValid()) {
                if (!File::exists(public_path($this->dir))) {
                    File::makeDirectory(public_path($this->dir), 0775, true);
                }

                $ext       = $video_tmp->getClientOriginalExtension();
                $videoName = $item->page_key . '-' . rand(111, 999999) . '.' . $ext;
                $video_tmp->move(public_path($this->dir), $videoName);

                // remove the previous video
                if ($item->video && file_exists(public_path($this->dir . '/' . $item->video))) {
                    unlink(public_path($this->dir . '/' . $item->video));
                }

                $item->video = $videoName;
            }
        }

        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            if ($image_tmp->isValid()) {
                if (!File::exists(public_path($this->dir))) {
                    File::makeDirectory(public_path($this->dir), 0775, true);
                }

                $extension = $image_tmp->getClientOriginalExtension();
                $file_name = $item->page_key . '-' . rand(111, 999999) . '.' . $extension;
                $image_path = $this->dir . '/' . $file_name;

                (new ImageManager(new Driver()))->decode($image_tmp)->save($image_path);

                // remove the previous file
                if ($item->image && file_exists($this->dir . '/' . $item->image)) {
                    unlink($this->dir . '/' . $item->image);
                }

                $item->image = $file_name;
            }
        }

        $item->position = $request->input('position', 'center');
        $item->save();

        return redirect('/admin/page-heroes')->with('success', 'Сохранено');
    }

    public function removeImage($id)
    {
        $item = PageHero::findOrFail($id);

        if ($item->image && file_exists($this->dir . '/' . $item->image)) {
            unlink($this->dir . '/' . $item->image);
        }

        $item->image = null;
        $item->save();

        return redirect('/admin/page-heroes')->with('success', 'Изображение удалено');
    }

    public function removeVideo($id)
    {
        $item = PageHero::findOrFail($id);

        if ($item->video && file_exists(public_path($this->dir . '/' . $item->video))) {
            unlink(public_path($this->dir . '/' . $item->video));
        }

        $item->video = null;
        $item->save();

        return redirect('/admin/page-heroes')->with('success', 'Видео удалено');
    }
}
