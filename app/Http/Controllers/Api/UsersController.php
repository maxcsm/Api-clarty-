<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\User;

class UsersController extends Controller
{


    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page;
        $per_page= $request->per_page;
        $order_id= $request->order_id;
        $filter= $request->filter;
        $order_by = $request->order_by;
        $category = $request->category;
        
        if (empty($filter)) {
            return User::orderBy($order_id, $order_by)
              -> paginate($per_page);
          }

            if (!empty($filter)) {
        return  User::query()
       // ->where('role', '=', $category)
        ->where('firstname', 'LIKE', "%{$filter}%")
        ->orWhere('lastname', 'LIKE', "%{$filter}%")
        ->orWhere('company', 'LIKE', "%{$filter}%")
        ->orWhere('email', 'LIKE', "%{$filter}%")
       // ->orWhere('id', 'LIKE', "%{$filter}%")
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(User::find($id), 200);
      
       
    }
       // 
    

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
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json('Deleted Successfully', 200);
    }


    public function updateAvatar($id, Request $request){
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }



      public function userByrole(Request $request)
    {
        $page = $request->page;
        $per_page= $request->per_page;
        $order_id= $request->order_id;
        $filter= $request->filter;
        $order_by = $request->order_by;

        return User::where('role', 'LIKE', "%{$filter}%")
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
    }

}
