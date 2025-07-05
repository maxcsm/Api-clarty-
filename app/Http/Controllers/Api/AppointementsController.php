<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointement;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\AppointementEmail;
use App\Mail\AppointementonemonthEmail;
use App\Mail\AppointementtowmonthEmail;

use Carbon\Carbon;

class AppointementsController extends Controller

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

        return Appointement::where('title', 'LIKE', "%{$filter}%")
            ->orWhere('id', 'LIKE', "%{$filter}%")
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


    $post = Appointement::create($request->all());

    return response()->json(['post'=>$post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointements = Appointement::find($id);
        $userid = $appointements->user_id;
        $techid = $appointements->edited_by;
        $users = DB::table('users')->where('id','=', $userid )
        ->select('users.*')
        ->get();

        $techs = DB::table('users')->where('id','=', $techid )
        ->select('users.*')
        ->get();


    return response()->json(['users'=>$users, 'techs'=> $techs,'appointement'=>  $appointements],200);
   // return response()->json(User::find($id), 200);
  
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
        $post = Appointement::findOrFail($id);
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
        Appointement::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function appointementsByUser($id, Request $request)
    {
        $page = $request->page;
        $per_page = $request->per_page;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $filter = $request->filter;

        if($filter){
            return Appointement::where('edited_by', $id)
            ->orWhere('user_id','=',$id)
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }else{
            return Appointement::where('edited_by', $id)
            ->orWhere('user_id','=',$id)
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }
    }

    public function appointementsByUserShort($id, Request $request)
    {
        $page = $request->page;
        $per_page = 10;
        $order_by = 'desc';
        $order_id = 'id';

        return Appointement::where('edited_by', $id)
        ->orWhere('user_id','=',$id)
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
    }



    public function appointementByUser($id, Request $request)
    {
      $appointements = DB::table('appointements')
       ->where('appointements.user_id',$id)
       ->orderBy("start_at", "desc")
       ->get();
       return response()->json($appointements, 200);

    }


    public function gallerieBypost($id, Request $request)
    {
      $appointements = DB::table('image_galleries')
       ->where('image_galleries.postid',$id)
       ->get();
       return response()->json($appointements, 200);

    }




    public function getlocation(Request $request)
    {

      $page = $request->page;
      $status=1;
      $per_page = 10;
      $order_id = 'id';
      $category = 'location';
      $status=1;
      $lat= $request->lat;
      $lng= $request->lng;
     // $dmin= $request->dmin;
     // $dmax= $request->dmax;
     // $tags = $request->tags;
 

      //$tags = collect([1,2,3,4]);
      $location = DB::table('users')
     // ->join('tags_location', 'tags_location.location_id', '=', 'locations.id')
     // ->whereIn('tags_location.tag_id', $tags)
      ->where('role', 2 )
     // ->where('role', 3 )
      ->select('users.id','users.firstname','users.lastname',
      \DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
      * cos(radians(users.lat)) 
      * cos(radians(users.lng) - radians(" . $lng . ")) 
      + sin(radians(" .$lat. ")) 
      * sin(radians(users.lat))) AS distance"))
     
  
       /* \DB::raw("6371 * acos(cos(radians(" .$lat. "))
      * cos(radians(locations.lat)) 
      * cos(radians(locations.lng) - radians(" .$lat. ")) 
      + sin(radians(" .$lng. ")) */
      ->distinct()
     // ->having('distance', '<', $dmax)
     // ->having('distance', '>', $dmin)
      ->orderBy('distance', 'asc')
      ->paginate($per_page);

      return response()->json(  $location, 200);


    }


    public function saveappointement(Request $request){
   
    $post = Appointement::create($request->all());
   
   
    $clientid = $request->user_id;
    $userid = $request->edited_by;

    $client = User::where('id',$clientid)->first();
    $tech = User::where('id',$userid)->first();
  
    $email = $tech->email;
    $user = new user;
    $user->firstname = $client->firstname;
    $user->lastname = $client->lastname;
    $user->company = $client->company;
    $user->subject = "Demande de rendez-vous";
    $user->message = $request->content;
    $test=$request->start_at;

    $test = strtotime($test);
    $user->jour= date('d-m-Y',$test);
    $user->heure= date('H:i',$test);
    Mail::to($email)->send(new AppointementEmail($user));
    return response()->json($user, 201);
    }


    public function getLocationAppointement()
    {
    
      $location= DB::table('appointements')
      ->join('users', 'appointements.user_id', '=', 'users.id')
      ->where('appointements.state', 2 )
      ->select('users.id','users.lat','users.lng','appointements.user_id','users.id','appointements.id', 
      'users.company', 'appointements.start_at', 'appointements.title')
      ->get();


    return response()->json(['location'=>$location],200);
   // return response()->json(User::find($id), 200);
  
    }


    public function AllAppointementTowMonth()
    {
      $nbemails = 0;
      //$date = Carbon::now()->addMonth()->timezone('Europe/Stockholm')->toDateTimeString();
      $date = Carbon::now()->addMonths(2)->timezone('Europe/Stockholm')->toDateTimeString();
      $datemax = Carbon::now()->addMonths(2)->addDay()->timezone('Europe/Stockholm')->toDateTimeString();

      $location= DB::table('appointements')
      ->join('users', 'appointements.user_id', '=', 'users.id')
      ->where('appointements.state', 2 )
      ->where('appointements.start_at','>', $date)
      ->where('appointements.start_at','<', $datemax)
      ->select('users.id','appointements.user_id','appointements.id', 'appointements.content', 
      'users.company', 'appointements.start_at', 'appointements.title', 'users.email','users.firstname','users.lastname', 'users.company')
      ->groupBy('user_id')
      ->get();
      
    
      foreach ($location as $items) {
        $email = $items->email; 

        $user = new user;
        $user->firstname = $items->firstname ;
        $user->lastname = $items->lastname;
        $user->company = $items->company;
        $user->subject = $items->title;
        $user->message = $items->content;
        $test=$items->start_at;
        $test = strtotime($test);
        $user->jour= date('d-m-Y',$test);
        $user->heure= date('H:i',$test);

        Mail::to($email)->send(new AppointementtowmonthEmail($user));
        $nbemails = $nbemails +1;
      }
     
    return response()->json([ 'date'=>$date,'datemax'=>$datemax, 'appointements'=>$location, 'nbemails'=>$nbemails  ],200);

  
    }
}
