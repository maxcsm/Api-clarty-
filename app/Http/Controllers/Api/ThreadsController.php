<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tread;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $page = $request->page;
        $per_page = $request->per_page;
        $filter = $request->filter;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $user_id = $request->user_id;


        return Tread::orderBy($order_id, $order_by)
            ->paginate($per_page);
    }

    // ->orderBy($order_id, $order_by)
    //   ->paginate($per_page);
    //


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
        $post = Tread::create($request->all());
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
        return response()->json(Tread::find($id), 200);
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
        $post = Tread::findOrFail($id);
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
        $post = Tread::findOrFail($id);
        if ($post)
            $post->delete();
        else
            return response()->json(error);
        return response()->json('page delete', 200);
    }



    public function threadByuser($id, Request $request)
    {
        $page = $request->page;
        $per_page = $request->per_page;
        $order_id = $request->order_id;
        $filter = $request->filter;
        $order_by = $request->order_by;

       return Tread::where('from_id', '=', $id)
            ->orWhere('to_id', '=', $id)
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);

    //     $user = Auth::user();
    //     $isOnline = $user->isOnline;
    //    dd($thread);
    //     return response()->json($thread, 200);
    }
}
