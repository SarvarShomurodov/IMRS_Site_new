<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HashTag extends Model
{
    public function infographics(){
      return $this->belongsToMany(\App\Models\PhotoGallery::class, 'infographics_hashtags', 'hashtag_id', 'infographic_id');
    }


    public function infographicExists($id){
      return $this->infographics()->where('infographic_id', $id)->exists();
    }
}
