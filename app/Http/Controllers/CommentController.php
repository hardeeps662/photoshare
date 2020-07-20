<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{   
     public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function getComments($id){
       return \App\Comment::where('album_id',$id)->with('user','replies.user')->get();

	}
    public function store(Request $request,$id){
    	
    	 $validatedData = $request->validate([
                'comment' => 'required|min:2',
         ]);

    	$requestData=$request->all();
        $requestData['user_id']=Auth::user()->id;
        $requestData['album_id']=$id;
        \App\Comment::create($requestData);
        return response()->json([$this->getComments($id)]);
    }
}
