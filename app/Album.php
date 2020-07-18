<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function images(){
    	return $this->hasMany(Image::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
