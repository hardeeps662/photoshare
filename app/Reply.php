<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{  
	protected $guarded=['album_id'];

    public function user(){
   	return $this->belongsTo(User::class);
   }

   public function comment(){
   return $this->belongsTo(Comment::class);
   }
   
   public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
}
