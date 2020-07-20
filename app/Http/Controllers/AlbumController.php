<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Album;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

         $albums=Album::where('user_id',Auth::user()->id)->with('category')->get();
        return view('album.index',compact('albums'));
    }

     public function getAlbum()
    {
         $albums=Album::where('user_id',Auth::user()->id)->with('category')->get(); 
         
      return $albums;   
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {          
        return view('album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  

        $validatedData = $request->validate([
                'name' => 'required|min:3',
                'description' => 'required|min:10',
                'category'=>'required',
                'file'=>'required|mimes:jpeg,jpg,png'
            ]);

        if ($request->has('file')) {
           $extension=$request->file->extension();
           $fileName=uniqid().'.'.$extension;
           $path = $request->file('file')->storeAs('public/album_cover', $fileName);
        }
        
        $album = new Album;
        $album->name=$request->name;
        $album->description=$request->description;
        $album->image=$fileName;
        $album->user_id=Auth::user()->id;
        $album->category_id=$request->category;
        $album->save();
        return response()->json([$this->getAlbum(),'message'=>'New Album is Created Successfully']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    
        return Album::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
          $validatedData = $request->validate([
                'name' => 'required|min:3',
                'description' => 'required|min:10',
                'category'=>'required',
            ]);


          $album = Album::find($id);
          $album->name=$request->name;
          $album->description=$request->description;
          $album->user_id=Auth::user()->id;
          $album->category_id=$request->category;
          $album->update();

           if ($request->has('file')) {
            $request->validate([
            'file'=>'required|mimes:jpeg,jpg,png'
            ]);
           $extension=$request->file->extension();
           $fileName=uniqid().'.'.$extension;
           $path = $request->file('file')->storeAs('public/album_cover', $fileName);
           $album->image=$fileName;
           $album->update();
        }
        
         return response()->json([$this->getAlbum(),'message'=>'Album is Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $album = \App\Album::find($id);

        Storage::disk('local')->delete('public/album_cover/'.$album->image);
        \App\Album::destroy($id);
        return response()->json([$this->getAlbum(),'message'=>'Album is Deleted Successfully']);
    }

    public function category()
    {
        $category = \App\Category::select('name','id')->get();
          return $category;
    }

}
