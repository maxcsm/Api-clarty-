<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagslocation;

use Illuminate\Support\Facades\DB;

class TagslocationController extends Controller
{
  
public function index(Request $request)
{
 
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

   $idtag = $request->input('idtag');
   $idlocation = $request->input('idlocation');
   DB::table('tags_location')->insert( ['location_id' =>  $idlocation, 'tag_id' => $idtag]  );
   return response()->json($idlocation, 200);

   //$tag = Tagslocation::create($request->all());
  // return response()->json($tag, 200);
}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
   return response()->json(Tagslocation::find($id), 200);
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
   $post = Tagslocation::findOrFail($id);
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

   $post= DB::table('tags_location')
   ->where('tags_location.pivot_id',$id)->delete();
   return response()->json('post delete', 200);
}


}
