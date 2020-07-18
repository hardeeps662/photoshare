<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded=[];

   public function user(){
   	return $this->belongsTo(User::class);
   }

   public function album(){
   	return $this->belongsTo(Album::class);
   }
   
   public function replies(){
    return $this->hasMany(reply::class);
   }

   
   public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
  
}
