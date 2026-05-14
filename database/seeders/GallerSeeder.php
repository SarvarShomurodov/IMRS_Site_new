<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhotoGallery;
use App\Models\VideoGallery;
use App\Models\Slider;

class GallerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photo = new PhotoGallery();
        $photo->image = '1.jpg';
        $photo->save();

        $photo = new PhotoGallery();
        $photo->image = '2.jpg';
        $photo->save();

        $video = new VideoGallery();
        $video->video = 'https://www.youtube.com/embed/V5iVC_dxJpc';
        $video->save();

        $video = new VideoGallery();
        $video->video = 'https://www.youtube.com/embed/T-59FkRYJO8';
        $video->save();

        $slider = new Slider();
        $slider->image_uz = '1.jpg';
        $slider->image_ru = '1.jpg';
        $slider->image_en = '1.jpg';
        $slider->save();
    }
}
