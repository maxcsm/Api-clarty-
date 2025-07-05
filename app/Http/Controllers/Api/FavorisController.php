<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Favoris;
use App\Models\Location;
class FavorisController extends Controller
{
    public function index(Request $request)
    {


      //$status = explode(',', $status );
      $page = $request->page;
      $per_page= $request->per_page;
      $order_by = $request->order_by;
      $order_id = $request->order_id;
      $user_id = $request->user_id;
      $filter = $request->filter;
            
      return Location::select('locations.id','locations.title','locations.city','locations.image','locations.edited_by')
      -> join('favoris', 'locations.id', '=', 'favoris.location_id')
      ->where('favoris.user_id', $filter)
      -> orderBy($order_id, $order_by)
      -> paginate($per_page);
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
       $tag = Favoris::create($request->all());
       return response()->json($tag, 200);
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
       return response()->json(Favoris::find($id), 200);


       
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
       $post = Favoris::findOrFail($id);
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
       $post = Favoris::findOrFail($id);
       if($post)
          $post->delete();
       else
           return response()->json(error);
       return response()->json('page favoris', 200);
    
    }
    
    public function favorisByUser($id, Request $request)
    {
       $page = $request->page;
       $per_page = $request->per_page;
       $order_by = $request->order_by;
       $order_id = $request->order_id;
       $filter = $request->filter;
    
           return Favoris::where('user_id', $id)
           ->orderBy($order_id, $order_by)
           ->paginate($per_page);
       
    }
    

   }