<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Auth;

class ReplyController extends Controller
{   
     public function __construct()
    {
        $this->middleware('auth');
    }
	public function getReply($id){
       return \App\Reply::where('comment_id',$id)->with('user')->get();

	}

    public function store(Request $request,$id){
    	
    	 $validatedData = $request->validate([
                'reply' => 'required|min:2',
         ]);
    	$requestData=$request->all();
       
        $requestData['user_id']=Auth::user()->id;
        $requestData['comment_id']=$id;
        \App\Reply::create($requestData);
         $comments=\App\Comment::where('album_id',$requestData['album_id'])->with('user','replies.user')->get();
        return $comments;
       
    }
}
