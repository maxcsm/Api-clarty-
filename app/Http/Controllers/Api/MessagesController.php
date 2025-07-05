<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\MessageAll;
    use App\Models\Message;
    use App\Models\Tread;
    use Illuminate\Support\Facades\DB;


    class MessagesController extends Controller
    {
        /**
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         */
        public function index($thread_id,Request $request)
        {

            $page = $request->page;
            $per_page= $request->per_page;
            $filter= $request->filter;
            $order_by = $request->order_by;
            $order_id = $request->order_id;

/*

            return Message::where('thread_id','=',$thread_id)

            ->orderBy($order_id, $order_by)
            ->paginate($per_page);

*/

            return  MessageAll::query()
            // ->where('role', '=', $category)
             ->where('thread_id','=',$thread_id)
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
            $post = Message::create($request->all());
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
            return response()->json(Message::find($id), 200);
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
            $post = Message::findOrFail($id);
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
            $post = Message::findOrFail($id);
            if($post)
               $post->delete();
            else
                return response()->json(error);
            return response()->json('page delete', 200);

        }


        public function messagesChat(Request $request)
        {
            $page = $request->page;
            $per_page= $request->per_page;
            $order_id= $request->order_id;
            $filter= $request->filter;
            $order_by = $request->order_by;
            $category = $request->category;
            $thread_id = $request->thread_id;
            
        
            //$allletter= User::select('firstname', DB::raw("SUBSTRING(firstname, 1, 1) as first_letter"))
            $messages= DB::table('messages')
            ->join('users', 'users.id', '=', 'messages.from_id')
            ->where('messages.thread_id', '=', $thread_id)
            ->select('messages.id','messages.body', 'messages.from_id', 'messages.thread_id',
             'messages.created_at','users.id','users.firstname','users.user_avatar' )
            ->orderBy('messages.created_at','desc')
            ->paginate($per_page);
            return response()->json(['messages'=>$messages],200);
         }
    


         public function messageNew(Request $request)
         {
           
             $treadform=$request->thread_id;

             $message = [];
             $message['from_id'] =  $request->from_id;
             $message['to_id'] = $request->to_id;
             $message['body'] = $request->body;
             $message['thread_id'] = $request->thread_id;
             $message = Message::create($message);
          

             /*
            if( $treadform==null){

             ///CRETION T+M
             $treadid=random_int(10000,99999);
             $treadinput = $request->all();
             $treadinput['thread_id'] = $treadid;
             $tread = Tread::create($treadinput);


             $message = [];
             $message['from_id'] =  $request->from_id;
             $message['to_id'] = $request->to_id;
             $message['body'] = $request->body;
             $message['thread_id'] = $treadid;
             $message = Message::create($message);
            } else {

            ///REPONSE MESSAGE

            $tread= DB::table('treads')
            ->where('treads.thread_id', '=', $treadform)
            ->select('*' )
            ->get();
   
            if($tread[0]->to_id!==$request->to_id){
             $toid=$tread[0]->to_id;    
             }else{
             $toid=$request->from_id;    
            }
    
             $message = [];
             $message['from_id'] =  $request->from_id;
             $message['to_id'] =$toid;
             $message['body'] = $request->body;
             $message['thread_id'] = $treadform;
             $message = Message::create($message);
            }
        */
             return response()->json(['message'=> $message  ],200);
          }
     
           
            
        


    }
