<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductsController extends Controller
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

        return Product::where('title', 'LIKE', "%{$filter}%")
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
        $post = Product::create($request->all());
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
        return response()->json(Product::find($id), 200);
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
        $post = Product::findOrFail($id);
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
        Product::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function productsByUser($id, Request $request)
    {
        $page = $request->page;
        $per_page = $request->per_page;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $filter = $request->filter;

        if($filter){
            return Product::where('edited_by', $id)
            ->where('content', 'LIKE', "%{$filter}%")
            ->orWhere('title', 'LIKE', "%{$filter}%")
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }else{
            return Product::where('edited_by', $id)
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

        return Product::where('edited_by', $id)
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
    }
}
