<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Models\Gallery;
use Intervention\Image\Facades\Image as ResizeImage;

class GalleryController extends Controller
{


    /**
     * Listing Of images gallery
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$images = Imagegallery::get();
    	return view('image-gallery',compact('images'));
    }


    /**
     * Upload image function
     *
     * @return \Illuminate\Http\Response
     */

    
    public function upload(Request $request)
    {
    header("Content-type: image/jpeg");
    $this->validate($request, [
    'title' => 'required',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    ]);
    $name = time().'.'.$request->image->getClientOriginalExtension();
    ResizeImage::make($request->file('image'))
    ->resize(300, 300)
    ->save(public_path('images/'.$name));
    return response()->json($name, 200);
    }





    public function uploadGalleryImage(Request $request)
    {

      	$this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);



        $name = time().'.'.$request->image->getClientOriginalExtension();
        ResizeImage::make($request->file('image'))
        ->resize(400, 300)
        ->save(public_path('images/'.$name));


        $input['image'] = $request->title;
        $input['posts_id'] = $request->postid;
        $input['url'] = $name;
        

        Gallery::create($input);

        return response()->json($name, 200);
    
/*
        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $input['image']);

*/
      

    //   return response()->json($input, 200);
    
    }
/*
     * Remove Image function
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Gallery::findOrFail($id);
        if($post)
           $post->delete();
        else
            return response()->json(error);
        return response()->json('gallery image delete', 200);
    }


    public function galleryByPost($id, Request $request)
    {
        $page = $request->page;
        $per_page = $request->per_page;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $filter = $request->filter;

        return Gallery::where('posts_id', $id)
        ->orderBy("id","ASC")
        ->paginate(100);
        
    }
}