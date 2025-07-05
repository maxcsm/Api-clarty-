<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tags;
use Illuminate\Support\Facades\DB;


class TagsController extends Controller
{
public function public_tags(Request $request)
{
   //$tags = Tags::all();
   //return response()->json($tags, 200);

   $page = 1;
   $per_page= 100;
   $order_id= "tag_fr";
   $order_by = "ASC";

   return Tags::orderBy('tag_fr', 'DESC')  
   ->paginate($per_page);
    
}

public function index(Request $request)
{

   $page = 1;
   $per_page= 100;
 
   return Tags::orderBy('tag_fr', 'ASC')  
   ->paginate($per_page);
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
   $post = Tags::create($request->all());
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
   return response()->json(Tags::find($id), 200);
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
   $post = Tags::findOrFail($id);
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
   $post = Tags::findOrFail($id);
   if($post)
      $post->delete();
   else
       return response()->json(error);
   return response()->json('page survey', 200);

}

public function postsByUser($id, Request $request)
{
   $page = $request->page;
   $per_page = $request->per_page;
   $order_by = $request->order_by;
   $order_id = $request->order_id;
   $filter = $request->filter;

   if($filter){
       return Tags::where('edited_by', $id)
       ->where('content', 'LIKE', "%{$filter}%")
       ->orWhere('title', 'LIKE', "%{$filter}%")
       ->orderBy($order_id, $order_by)
       ->paginate($per_page);
   }else{
       return Tags::where('edited_by', $id)
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

   return Tags::where('edited_by', $id)
   ->orderBy($order_id, $order_by)
   ->paginate($per_page);
}


public function addtag( Request $request)
{
   $idtag = $request->input('tag_fr');
   $tag =   DB::table('tags')->insert( ['tag_fr' =>  $idtag]  );
   return response()->json($tag, 200);

   
}
}
