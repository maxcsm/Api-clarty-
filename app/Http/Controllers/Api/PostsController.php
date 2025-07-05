<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Image; //Intervention Image
use Illuminate\Support\Facades\Storage; //Laravel Filesystem
use Illuminate\Support\Facades\Http;



use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page;
        $per_page= $request->per_page;
        $filter= $request->filter;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $category = $request->category;
        $status=$request->status;
        //$view = [preg_replace("/\"/","'",$status)];

        if (empty($filter)) {
            return Post::where('category',$category) 
            -> orderBy($order_id, $order_by)
            -> paginate($per_page);
        }

        if (!empty($filter)) {
            return Post::where('category',$category) 
            -> where('title', 'LIKE', "%{$filter}%")
            -> orWhere('id', 'LIKE', "%{$filter}%")
            -> orderBy($order_id, $order_by)
            -> paginate($per_page);
        }
  
      
/*
       if (empty($filter)) {
            return Post::whereIn('view',[0,1])
              -> where('category',$category) 
              -> orderBy($order_id, $order_by)
              -> paginate($per_page);
          }

            if (!empty($filter)) {
                return Post::whereIn('view', [0,1])
                -> where('category',$category) 
                -> where('title', 'LIKE', "%{$filter}%")
                -> orWhere('id', 'LIKE', "%{$filter}%")
                -> orderBy($order_id, $order_by)
                -> paginate($per_page);
            }

*/
      //return response()->json($view, 200);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create($request->all());

/*
        $heading = array(
          "en" => $request->title,"fr" => $request->title,
        );
        $content = array(
          "en" => $request->content,"fr" =>  $request->content,
          );

        $fields = array(
          'app_id' => "6348c229-5adb-4720-9923-3c412abc09cf",
          'headings' => $heading,
          'contents' => $content,
        //   'include_player_ids' => ["$idpushuser"],
          'included_segments' => array('All'),
          'data' => array("foo" => "demande")
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                               'Authorization: Basic MzU3NzA1YWM'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
*/


        return response()->json($post, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Post::find($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post)
           $post->delete();
        else
            return response()->json(error);
        return response()->json('post delete', 200);
    }

    public function postsByUser($id, Request $request)
    {
        $page = $request->page;
        $per_page = $request->per_page;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $filter = $request->filter;

        if($filter){
            return Post::where('edited_by', $id)
            ->where('content', 'LIKE', "%{$filter}%")
            ->orWhere('title', 'LIKE', "%{$filter}%")
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }else{
            return Post::where('edited_by', $id)
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }
    }

    public function postsByUserShort($id, Request $request)
    {
        $page = $request->page;
        $per_page = 10;
        $order_by = 'desc';
        $order_id = 'id';

        return Post::where('edited_by', $id)
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
    }



    public function public_posts_short()
    {
      
        $per_page = 10;
        $order_by = 'desc';
        $order_id = 'id';

        return Post::orderBy($order_id, $order_by)
        ->where('view', 1)
        ->paginate($per_page);
    }



    public function upload22( Request $request)
    {

        $file = $request->file('image');
        $destinationPath = 'images';
      //  $myimage = $request->image->getClientOriginalName();
     //   $request->image->move(public_path($destinationPath),   $file);

        $url = Storage::putFileAs('images',$file, "1545554". '.' . $file->extension());

       // $file = $request->file('image');
       // $name = random_int(100000,999999);
       // $url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());

  
   

        /* 
            Write Code Here for
            Store $imageName name in DATABASE from HERE 
        */
      
       
        return response()->json(
            [  "HELLLO"
        ],200);
           
    }
    


    public function upload( Request $request)
    {

        
    if ($request->hasFile('image')) {
        foreach($request->file('image') as $file){
            //get filename with extension
            $filenamewithextension = $file->getClientOriginalName();
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //get file extension
            $extension = $file->getClientOriginalExtension();
            //filename to store
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;
          //  Storage::put('public/profile_images/'. $filenametostore, fopen($file, 'r+'));
           // Storage::put('public/profile_images/thumbnail/'. $filenametostore, fopen($file, 'r+'));
            //Resize image here
          //  $thumbnailpath = public_path('profile_images/thumbnail/'.$filenametostore);
       //     $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
           //     $constraint->aspectRatio();
        //    });
           // $img->save($thumbnailpath);
        }


        return response()->json(
            [ $filenametostore
        ],200);
      
    }
    }

    public function public_post($id)
    {
        return response()->json(Post::find($id), 200);
    }


    public function public_count()
    {
      
        $location = DB::table('locations')->count();
        $location_publised = DB::table('locations')->where('view','=','1')->count();
        $post = DB::table('posts')->count();
        $post_publised = DB::table('posts')->where('view','=','1')->count();
        $user = DB::table('users')->count();
        $user_user = DB::table('users')->where('role','=','1')->count();
        $user_admin = DB::table('users')->where('role','=','2')->count();
        $page = DB::table('pages')->count();
        $page_publised = DB::table('pages')->where('view','=','1')->count();
        $category= DB::table('tags')->count();
        return response()->json(
            ['location'=>$location,'location_publised'=>$location_publised,
            'post'=>$post,'post_publised'=>$post_publised,
            'user'=>$user,'user_user'=>$user_user,'user_admin'=>$user_admin,
            'page'=>$page,'page_publised'=>$page_publised,
            'category'=>$category,
        ],200);
    }



    public function postnotation(Request $request)
    {
        $idproduct = $request->idpost;
        $iduser = $request->iduser;
        $note = $request->note;
        $comment = $request->comment;
        $tag = DB::table('notation_product')->insert( ['idproduct' =>  $idproduct,'iduser' => $iduser, 'note'=> $note, 'comment' => $comment	]);
     
        return response()->json($tag, 201);
    }





    public function postnotes($id,Request $request)
    {
    
        $products = DB::table('notation_product')
        ->select('notation_product.id', 'notation_product.idproduct', 'notation_product.iduser', 'notation_product.note', 'notation_product.comment', 'users.id', 'users.firstname' )
        ->join('users', 'users.id', '=', 'notation_product.iduser')
        ->where('notation_product.idproduct','=',  $id)
        ->orderBy('notation_product.id', "asc")
        ->get();
        
        return response()->json( $products, 201);

    }


    public function languagetool(Request $request)
    {
      
    // Validate the request input
    $request->validate([
        'text' => 'required|string',
    ]);

    $text = $request->input('text');



    $text = $request->text;
    $response = Http::asForm()->post('https://api.languagetool.org/v2/check', [
        'text' => $text,
        'language' => 'fr',
    ]);
  

    return response()->json($response->json(), 200);

    }


}




   

