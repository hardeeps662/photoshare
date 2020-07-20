<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Auth;

class ImagesController extends Controller
{  

     public function __construct()
    {
        $this->middleware('auth');
    }

	public function getImages($id){
        $images = \App\Image::where('album_id',$id)->get();
        return $images;
	}
    public function create($id)
    {
        return view('images.create',compact('id'));
    }

    public function store(Request $request,$id){

    	$validatedData = $request->validate([
    	        'file'=>'required',
    	        'file.*' => 'image|mimes:jpeg,png,jpg,gif',
    	    ]);
    	$requestData=$request->file;
       	foreach($requestData as $key => $image) {
    		 $extension=$image->extension();
    		 $fileName=uniqid().'.'.$extension;
    		 $path = $image->storeAs('public/album_image', $fileName);

    		 $image = new Image;
    		 $image->photo=$fileName;
    		 $image->album_id=$id;
    		 $image->user_id=Auth::user()->id;
    		 $image->save();
        }
        return response()->json([$this->getImages($id),'message'=>'Images Upload Successfully']);
    }

    public function delete($id){
         $image=Image::find($id);
         $image->delete();
         return response()->json([$this->getImages($id),'message'=>'image deleted successfully']);
    }
}
