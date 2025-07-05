<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page;
        $per_page= $request->per_page;
        $filter= $request->filter;
        $order_by = $request->order_by;
        $order_id = $request->order_id;

        return File::where('title', 'LIKE', "%{$filter}%")
        ->orWhere('content', 'LIKE', "%{$filter}%")
        ->orderBy($order_id, $order_by)
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
        $post = File::create($request->all());
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(File::find($id), 200);
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
        $post = File::findOrFail($id);
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
        File::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function filesByUser($id, Request $request)
    {
        $page = $request->page;
        $per_page = $request->per_page;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $filter = $request->filter;

        if($filter){
            return File::where('edited_by', $id)
            ->where('content', 'LIKE', "%{$filter}%")
            ->orWhere('title', 'LIKE', "%{$filter}%")
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }else{
            return File::where('edited_by', $id)
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }
    }

    public function productsByUserShort($id, Request $request)
    {
        $page = $request->page;
        $per_page = 10;
        $order_by = 'desc';
        $order_id = 'id';

        return File::where('edited_by', $id)
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
    }




  public function askdoc(Request $request)  {

    $file_id= $request->file_id;

    $ch = curl_init();
    $url = 'https://api.openai.com/v1/threads/';
    $api_key = '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'; // replace with your key
    
    $post_fields = json_encode([
     "role" => "user",
     "content" => "Quel est le nom du document ?",

    "attachments" => [
    
        "file_id" =>$file_id,
        "tools" => ["type" =>"code_interpreter"]
      
    ]
   ]);
 
    $header  = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $api_key,
      'OpenAI-Beta: assistants=v2' 
    ];
  
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,   $post_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      echo 'Error: ' . curl_error($ch);
    }

    header("Content-Type: application/json");
    $response = json_decode($result);
    curl_close($ch);

  return response()->json(['response '=> $response],200);
   /// $this->stream($thread_id);

  }

}
