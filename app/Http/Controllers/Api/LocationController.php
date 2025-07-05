<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use App\Models\File;
use App\Models\Assistant;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;
use App\Services\OpenAIService; 

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

           //  $status = explode(',', $status );

        $page = $request->page;
        $per_page= $request->per_page;
        $filter= $request->filter;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $category = $request->category;
        $status=$request->status;
        
  
        if (empty($filter)) {
          return Location::orderBy($order_id, $order_by)
            -> paginate($per_page);
        }
    


        if (!empty($filter)) {
              return Location::select('*')
                -> where('title', 'LIKE', "%{$filter}%")
                -> orWhere('id', 'LIKE', "%{$filter}%");
              //  -> orderBy($order_id, $order_by)
              //  -> paginate($per_page);
        }

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
      $location =  Location::create($request->all());
      return response()->json($location, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $location = DB::table('locations')
      ->join('users', 'locations.edited_by', '=', 'users.id')
      ->where('locations.id', $id)
      ->select('*')
      ->get();

      $tags= DB::table('tags_location')
      ->join('tags', 'tags_location.tag_id', '=', 'tags.id')
      ->where('tags_location.location_id', $id)
      ->select('tags.tag_fr','tags.tag_en','tags.tag_de')
      ->get();
      
      return response()->json(['location'=>$location,'tags'=>$tags],200);
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
        $post = Location::findOrFail($id);
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
        $post = Location::findOrFail($id);
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
            return Location::where('edited_by', $id)
            ->where('content', 'LIKE', "%{$filter}%")
            ->orWhere('title', 'LIKE', "%{$filter}%")
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }else{
            return Location::where('edited_by', $id)
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

        return Location::where('edited_by', $id)
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
    }


    public function assitant_create_withoutfile(Request $request)
    {
    
      
        $title="chat";
        $userid=$request->userid;
        $category=$request->category;
      
        $ch = curl_init();
        $url = 'https://api.openai.com/v1/assistants';
        $api_key =  env('api_key');

      
        $post_fields= json_encode([
        "instructions"=>  "Afficher la réponse sous fome de points avec des couleur comme Chat GPT 
    ajouter des émoticônes beaucoup, Supprimer les tirets, Tu es un assistant qui répond sans jamais utiliser d'astérisques ou d'étoiles.  Supprimer les astérisques ou de hashtags, ne pas utiliser de syntaxe Markdown, 
     ajouter les lignes entière entre les paragraphes avec des retours à la ligne",
        "model"=>  "gpt-4o",
        "temperature"=> 0.3
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
      
      
      
      
      
        $ch2 = curl_init();
        $url = 'https://api.openai.com/v1/threads';
        $api_key = env('api_key'); 
        
        $data = json_encode([
    
        ]);
      
      
        $header  = [
          'Content-Type: application/json',
          'Authorization: Bearer ' . $api_key,
          'OpenAI-Beta: assistants=v2' 
        ];
      
        curl_setopt($ch2, CURLOPT_URL, $url);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_POSTFIELDS,  $data);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $header);
      
        $result2 = curl_exec($ch2);
        if (curl_errno($ch2)) {
          echo 'Error: ' . curl_error($ch2);
        }
        curl_close($ch2);
        
        $response2 = json_decode($result2);
        $thread_id= $response2->id ;
        //return $this->searchCategoryByAssistant($response->id, $thread_id);
      
      
        $assistant = new Assistant;
        $assistant->title = $title;
        $assistant->thread_id = $thread_id;
        $assistant->assitant_id = $response->id;
        $assistant->edited_by = $userid;
        $assistant->category = $category;
        $assistant->save();
      
      
      
      
      
       return response()->json(['assitantid'=> $response->id, 'thread_id'=> $thread_id, 'assistant'=> $assistant],200);
      
      }
      
      











    public function newthread_chatgpt(Request $request)
    {
      $vectorStoreId= $request->vectorStoreId;
      $ch = curl_init();
      $url = 'https://api.openai.com/v1/threads';
      $api_key = env('api_key');
      
      $data = json_encode([
       "tool_resources"=>["file_search"=>["vector_store_ids"=>[$vectorStoreId]]]
      ]);






      $header  = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
        'OpenAI-Beta: assistants=v2' 
      ];
    
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    
      $result = curl_exec($ch);
      if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
      }
      curl_close($ch);
      
      $response = json_decode($result);

      $thread_id= $response->id ;

      return response()->json(['thread_id'=>$thread_id],200);
    }








    public function addmessage_chatgpt(Request $request)  {


      $message= $request->message;
      $thread_id= $request->thread_id;
  
      $ch = curl_init();
      $url = 'https://api.openai.com/v1/threads/'.$thread_id.'/messages';
      $api_key = env('api_key');
      
      $post_fields = json_encode([
     "role" => "user",
     "content" => $message,
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







      function stream($thread_id)  {

      $ch = curl_init();
      $url = 'https://api.openai.com/v1/threads/'.$thread_id.'/runs';
      $api_key = env('api_key');
      
      $post_fields= json_encode([
      "assistant_id" => "asst_SJuxhyBNM8DZdmDajN07FDMU",
      //"additional_instructions" => NULL,
      //"tool_choice" => NULL,
      "stream" => true, 
      
      ]);
      
      $header  = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
        'OpenAI-Beta: assistants=v2',
         'Accept:text/event-stream'
      ];
      
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,   $post_fields);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      
      $result= curl_exec($ch);
      if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
      }
      header("Content-Type: application/json");
      $response = json_decode($result);
      curl_close($ch);



      return response()->json(['response '=> $response],200);
      
      }

    



















public function public_chatgpt( $thread_id){
///  $response = json_decode($result);
$curl = curl_init();

$url = 'https://api.openai.com/v1/threads/'.$thread_id.'/messages';
$api_key =env('api_key');

$header  = [
  'Content-Type: application/json',
  'Authorization: Bearer ' . $api_key,
  'OpenAI-Beta: assistants=v2' 
];

$post_fields= json_encode([
  "assistant_id" => "asst_SJuxhyBNM8DZdmDajN07FDMU",
  //"additional_instructions" => NULL,
  //"tool_choice" => NULL,
  "stream" => true, 
  
  ]);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.openai.com/v1/threads/'.$thread_id.'/messages',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => $header),
);

$responseMessages = curl_exec($curl);
$responseMessages  = json_decode($responseMessages  );



header("Content-Type: application/json");

curl_close($curl);
return response()->json(['thread_id'=>$thread_id,'messages'=> $responseMessages],200);

}

 

public function public_assitant_files(){

$curl = curl_init();

$url = 'https://api.openai.com/v1/files';
$api_key = env('api_key');

$header  = [
  'Content-Type: application/json',
  'Authorization: Bearer ' . $api_key,
  'OpenAI-Beta: assistants=v2' 
];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.openai.com/v1/files',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => $header),
);

$responseMessages = curl_exec($curl);
$responseMessages  = json_decode($responseMessages  );
header("Content-Type: application/json");
curl_close($curl);
return response()->json(['files'=> $responseMessages],200);

}



public function public_assitant_uploadfile(Request $request){
// Validate the file
$request->validate([
    'file' => 'required|file|mimes:json,txt,pdf|max:2048', // Accepts JSON, TXT, PDF (Max 2MB)
]);
        // Récupérer le fichier depuis la requête
          $file = $request->file('file');


  
    

      // Sauvegarder le fichier sur le "disk" configuré (public ici)
      //$path = $file->store('uploads', 'public');

      // Récupérer l'URL du fichier
      //$url = Storage::url($path);



$filePath = $file->getPathname();
$fileName = $file->getClientOriginalName();
$apiKey = env('api_key');
  
          // Prepare cURL request
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.openai.com/v1/files',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
     "Authorization: Bearer $apiKey"
    ],
    CURLOPT_POSTFIELDS => [
      'file' => new \CURLFile($filePath, mime_content_type($filePath), $fileName),
      'purpose' => 'assistants' // Use for retrieval-based search
    ]
    ]);
  
    $response = curl_exec($curl);
    curl_close($curl);
  
    return response()->json(json_decode(   $response, true));
}
  




  public function public_assitant_uploadFromUrlToCurl(Request $request){
  
          $url= $request->url;
          $response = Http::get($url);
          $contents = $response->body();

          // Store the file temporarily (for uploading to OpenAI)
          // $tempFilePath = 'storage/app';
          // Storage::put($tempFilePath, $fileContent);
          // Now upload the file to OpenAI
          // $file = fopen(storage_path($tempFilePath), 'r');
          // $contents = file_get_contents($url);

       if ($contents !== false) {
          $fileName = 'public/' . basename($url);
          Storage::put($fileName, $contents);
          $url2 = Storage::url($fileName); 
          //$fileName = $file->getClientOriginalName();
          $filePath = storage_path('app/public/'.basename($url2));
       
          $apiKey = env('api_key');

          // Prepare cURL request
          $curl = curl_init();
          curl_setopt_array($curl, [
              CURLOPT_URL => 'https://api.openai.com/v1/files',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_POST => true,
              CURLOPT_HTTPHEADER => [
               "Authorization: Bearer $apiKey"
              ],
              CURLOPT_POSTFIELDS => [
                'file' => new \CURLFile($filePath , "application/pdf", $fileName),
                'purpose' => 'assistants' // Use for retrieval-based search
              ]
              ]);
            
              $response = curl_exec($curl);
              curl_close($curl);
   
             
             return response()->json(json_decode(   $response, true));
            } else {

              return response()->json(['response '=> "Failed to download file."],200);
         
          }
          
  }





public function vector_store_file(Request $request)
{

  $file_id= $request->file_id;
  $vector_store_id=$request->vector_store_id;

  $ch = curl_init();
  $url = 'https://api.openai.com/v1/vector_stores/'.$vector_store_id.'/file_batches';
  $api_key = env('api_key');


  $post_fields = json_encode([
  "file_ids" =>  $file_id
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



}


public function assitant_create(Request $request)
{

  $vector_store_id=$request->vector_store_id;

  $ch = curl_init();
  $url = 'https://api.openai.com/v1/assistants';
  $api_key = env('api_key');
  

  $post_fields= json_encode([
    "instructions"=>  "Afficher le nom du contrat et le nom de la mutelle en premier , Afficher le montant des remboursements par type d'équipement, Afficher la réponse sous fome de points avec des couleur comme Chat GPT 
    ajouter des émoticônes beaucoup, Supprimer les tirets, Tu es un assistant qui répond sans jamais utiliser d'astérisques ou d'étoiles.  Supprimer les astérisques ou de hashtags, ne pas utiliser de syntaxe Markdown, 
     ajouter les lignes entière entre les paragraphes, 
    afficher à la fin la source, ajouter une formule de politesse exemple :  voici le montant de votre remboursement pour les lunettes .
    Au plaisir de vous aider ! N’hésitez pas si vous avez d’autres questions., Si l'assitant de ne trouve pa la réponse afficher cette réponse sans formule de politesse : Désolé, je ne suis pas formé pour répondre à ce type de question. N’hésitez pas à me poser une question concernant votre contrat ou vos remboursements.",
    "tools"=> [["type"=> "file_search"]],
    "tool_resources"=> ["file_search"=> 
    [ "vector_store_ids"=>  [$vector_store_id]]],
    "model"=>  "gpt-4o",
    "temperature"=> 0.3
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



}








public function searchCategoryByFileId(Request $request)
{

$fileId= $request->file_id;
$file_id_db= $request->file_id_db;



$ch = curl_init();
$url = 'https://api.openai.com/v1/files/'.$fileId;
$api_key = env('api_key');
$question = "Quel est le sujet du fichier ?";



$post_fields= json_encode([
  'model' => 'gpt-4',
  'question' => $question,
  'file_ids' => [$fileId],  // The file ID
  'max_responses' => 1
  ]);

$header  = [
  'Content-Type: application/json',
  'Authorization: Bearer ' . $api_key,
];

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,   $post_fields);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

$result = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error: ' . curl_error($ch);
}

header("Content-Type: application/json");

$response = json_decode($result);
curl_close($ch);

$file = File::findOrFail($file_id_db);
$file['title'] =  $response->filename;
$file->save(); 
return response()->json(['response '=> $response->filename],200);
}






public function searchDataByFileId(Request $request)
{

  $file_id_db=$request->file_id_db;
  $vector_store_id=$request->vector_store_id;


  $ch = curl_init();
  $url = 'https://api.openai.com/v1/assistants';
  $api_key = env('api_key');

  $post_fields= json_encode([
  "instructions"=>  "Quel est catégorie du fichier parmi les catgories suivantes : Assurance Auto / Moto , Assurance Habitation, Mutuelle Santé, Assurance
   Emprunteur, Électricité / Gaz? ",
  "tools"=> [["type"=> "file_search"]],
  "tool_resources"=> ["file_search"=> 
  [ "vector_store_ids"=>  [$vector_store_id]]],
  "model"=>  "gpt-4o",
  "temperature"=> 0.3
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





  $ch = curl_init();
  $url = 'https://api.openai.com/v1/threads';
  $api_key = env('api_key');
  
  $data = json_encode([
   "tool_resources"=>["file_search"=>["vector_store_ids"=>[$vector_store_id]]]
  ]);


  $header  = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
    'OpenAI-Beta: assistants=v2' 
  ];

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

  $result2 = curl_exec($ch);
  if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
  }
  curl_close($ch);
  
  $response2 = json_decode($result2);
  $thread_id= $response2->id ;
  //return $this->searchCategoryByAssistant($response->id, $thread_id);
 return response()->json(['assitantid'=> $response->id, 'thread_id'=> $thread_id],200);

}



public function createAssitantByCategory(Request $request)
{

  $file_id_db=$request->file_id_db;
  $vector_store_id=$request->vector_store_id;

  $category=$request->category;

  if (str_contains($category, 'Auto')) {
    $question="Répondre aux questions suivantes sous forme de points : Nom du souscripteur, Date de naissance, Type et date de permis, Marque, modèle et cylindrée,Date de mise en circulation, 
  Usage déclaré (privé, pro, etc.), Mode de stationnement,Kilométrage annuel,Niveau de couverture (tiers, tous risques...),Bonus / malus,
  Conducteur secondaire,Nom assurance,Dates de début du contrat, Dates échéance du contrat,Montant des cotisations";
  
  }
  
  if (str_contains($category, 'Habitation')) {

  $question="Répondre aux questions suivantes sous forme de points : Adresse assurée,Type de logement (maison, appartement), Surface habitable,Statut du souscripteur (locataire, propriétaire),Nombre d’occupants, Année de construction (si mentionnée),Valeur des biens mobiliers assurés, Garanties souscrites (vol, incendie, dégât des eaux...),
  Dépendances assurées (garage, cave...), Systèmes de sécurité, Assureur, Date de début et échéance du contrat, Montant et fréquence des cotisations";

}

if (str_contains($category, ' Santé')) {
  $question="Répondre aux questions suivantes sous forme de points : Nom du bénéficiaire principal, Nombre de personnes couvertes, Régime de sécurité sociale, Garanties : optique, dentaire, hospitalisation, Tiers payant inclus ?, Niveaux de remboursement par poste, 
  Date d’effet du contrat, Nom de la mutuelle, Montant des cotisations";


 }
 
 if (str_contains($category, 'Emprunteur')) {

    $question="Répondre aux questions suivantes sous forme de points : Organisme assureur, Montant total emprunté, Durée et date de début du prêt, Garanties souscrites (décès, invalidité, ITT...), Quotité assurée (si co-emprunteur), Éventuelles exclusions,
     Montant et fréquence des cotisations, Échéance du contrat";

}

if (str_contains($category, 'Gaz')) {
   $question="Répondre aux questions suivantes sous forme de points : Adresse du lieu de consommation, Fournisseur actuel, Type d’énergie (électricité, gaz, les deux), Type d’offre (base, HP/HC, verte...), Puissance du compteur (kVA), 
Durée d’engagement, Dates de début et d’échéance,Consommation estimée (kWh ou m³), Prix du kWh et de l’abonnement, Promotions ou remises appliquées";
}


return $this->searchData($vector_store_id, $question); 

}
public function searchData($vector_store_id, $question)
{


  $ch = curl_init();
  $url = 'https://api.openai.com/v1/assistants';
  $api_key = env('api_key');
  

  $post_fields= json_encode([
  "instructions"=>  $question,
  "tools"=> [["type"=> "file_search"]],
  "tool_resources"=> ["file_search"=> 
  [ "vector_store_ids"=>  [$vector_store_id]]],
  "model"=>  "gpt-4o",
  "temperature"=> 0.3
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





  $ch = curl_init();
  $url = 'https://api.openai.com/v1/threads';
  $api_key = env('api_key');
  $data = json_encode([
   "tool_resources"=>["file_search"=>["vector_store_ids"=>[$vector_store_id]]]
  ]);


  $header  = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
    'OpenAI-Beta: assistants=v2' 
  ];

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

  $result2 = curl_exec($ch);
  if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
  }
  curl_close($ch);
  
  $response2 = json_decode($result2);
  $thread_id= $response2->id ;
  //return $this->searchCategoryByAssistant($response->id, $thread_id);
 return response()->json(['assitantid'=> $response->id, 'thread_id'=> $thread_id],200);

}




public function CreateAssistantThreadByFile(Request $request)
{

  $title=$request->title;
  $userid=$request->userid;
  $vector_store_id=$request->vector_store_id;
  $category=$request->category;

  $ch = curl_init();
  $url = 'https://api.openai.com/v1/assistants';
  $api_key = env('api_key');
  



  $post_fields= json_encode([
    "instructions"=>  "Tu es Clarty, assistant expert en assurance, mutuelle et énergie. Ton rôle est d’analyser le fichier envoyé par l’utilisateur et de lui fournir une réponse claire, structurée, chaleureuse et engageante, 
      selon le type de contrat détecté. Utilise un ton humain, professionnel, avec des emojis et une mise en page lisible. Tu dois toujours terminer ta réponse par des appels à l’action utiles (ex. : envoi de devis, comparaison d’offres, 
      reste à charge estimé, etc.).
      1. Identifie la catégorie du contrat (mutuelle santé, prévoyance, assurance habitation, assurance auto, électricité/gaz).\n\n
      2. MUTUELLE : détaille les remboursements (ex. optique, dentaire, hospitalisation) en fonction du contrat. Donne des montants, des tableaux, des exemples.\n\n
      3. HABITATION : explique les garanties (incendie, dégât des eaux, vol…), les plafonds d’indemnisation, les franchises. Mets en avant les exclusions éventuelles.\n\n
      4. AUTO : indique les niveaux de couverture (tiers, tous risques), les plafonds, les franchises, les options. Mets en lumière les cas non couverts.\n\n
      5. PRÉVOYANCE : explique les garanties décès, invalidité, arrêt de travail, etc. Affiche les montants et durées d’indemnisation.\n\n
      6. ÉLECTRICITÉ/GAZ : affiche le montant des abonnements, le tarif du kWh, la durée d’engagement, les conditions de résiliation.\n\n
      7. Termine toujours par une proposition d'action utile :\n  
       - 📄 “Envie d’un devis ?” ➡️ Propose d’utiliser l’onglet *Devis*\n  
        - ⚖️ “Besoin de comparer ?” ➡️ Oriente vers l’outil *Comparer*\n  
         - 🔍 “Vous voulez une analyse personnalisée ?” ➡️ Propose à l’utilisateur d’envoyer les montants précis (prix mensuel, franchise, etc.).
      \n\n
      Adapte le contenu à chaque cas, évite les termes techniques non expliqués, structure bien le texte avec des retours à la ligne, des icônes et des paragraphes aérés.
      Ajouter des émoticônes beaucoup, Supprimer les tirets. 
      Supprimer les astérisques ou de hashtags, ne pas utiliser de syntaxe Markdown.
     Ajouter les lignes entière entre les paragraphes et retour à la ligne.",
    "tools"=> [["type"=> "file_search"]],
    "tool_resources"=> ["file_search"=> 
    [ "vector_store_ids"=>  [$vector_store_id]]],
    "model"=>  "gpt-4o",
    "temperature"=> 0.7
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





  $ch2 = curl_init();
  $url = 'https://api.openai.com/v1/threads';
  $api_key = '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'; // replace with your key
  
  $data = json_encode([
   "tool_resources"=>["file_search"=>["vector_store_ids"=>[$vector_store_id]]]
  ]);


  $header  = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
    'OpenAI-Beta: assistants=v2' 
  ];

  curl_setopt($ch2, CURLOPT_URL, $url);
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch2, CURLOPT_POST, 1);
  curl_setopt($ch2, CURLOPT_POSTFIELDS,  $data);
  curl_setopt($ch2, CURLOPT_HTTPHEADER, $header);

  $result2 = curl_exec($ch2);
  if (curl_errno($ch2)) {
    echo 'Error: ' . curl_error($ch2);
  }
  curl_close($ch2);
  
  $response2 = json_decode($result2);
  $thread_id= $response2->id ;
  //return $this->searchCategoryByAssistant($response->id, $thread_id);


  $assistant = new Assistant;
  $assistant->title = $title;
  $assistant->id_vector =$vector_store_id;
  $assistant->thread_id = $thread_id;
  $assistant->assitant_id = $response->id;
  $assistant->edited_by = $userid;
  $assistant->category = $category;
  $assistant->save();





 return response()->json(['assitantid'=> $response->id, 'thread_id'=> $thread_id, 'assistant'=> $assistant],200);

}


/*
public function CreateAssistantThreadByFile(Request $request)
{

  $title=$request->title;
  $userid=$request->userid;
  $vector_store_id=$request->vector_store_id;
  $category=$request->category;

  $ch = curl_init();
  $url = 'https://api.openai.com/v1/assistants';
  $api_key = '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'; // replace with your key
  

  $post_fields= json_encode([
  "instructions"=>  "Afficher le nom du contrat et le nom de la mutelle en premier, Afficher la réponse sous fome de points avec des couleur comme Chat GPT 
    ajouter des émoticônes beaucoup, Supprimer les tirets.  Supprimer les astérisques ou de hashtags, ne pas utiliser de syntaxe Markdown.
     ajouter les lignes entière entre les paragraphes et retour à la ligne. Proposer d'autres réponses d'internet",
  "tools"=> [["type"=> "file_search"]],
  "tool_resources"=> ["file_search"=> 
  [ "vector_store_ids"=>  [$vector_store_id]]],
  "model"=>  "gpt-4o",
  "temperature"=> 0.7
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





  $ch2 = curl_init();
  $url = 'https://api.openai.com/v1/threads';
  $api_key = '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'; // replace with your key
  
  $data = json_encode([
   "tool_resources"=>["file_search"=>["vector_store_ids"=>[$vector_store_id]]]
  ]);


  $header  = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
    'OpenAI-Beta: assistants=v2' 
  ];

  curl_setopt($ch2, CURLOPT_URL, $url);
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch2, CURLOPT_POST, 1);
  curl_setopt($ch2, CURLOPT_POSTFIELDS,  $data);
  curl_setopt($ch2, CURLOPT_HTTPHEADER, $header);

  $result2 = curl_exec($ch2);
  if (curl_errno($ch2)) {
    echo 'Error: ' . curl_error($ch2);
  }
  curl_close($ch2);
  
  $response2 = json_decode($result2);
  $thread_id= $response2->id ;
  //return $this->searchCategoryByAssistant($response->id, $thread_id);


  $assistant = new Assistant;
  $assistant->title = $title;
  $assistant->id_vector =$vector_store_id;
  $assistant->thread_id = $thread_id;
  $assistant->assitant_id = $response->id;
  $assistant->edited_by = $userid;
  $assistant->category = $category;
  $assistant->save();





 return response()->json(['assitantid'=> $response->id, 'thread_id'=> $thread_id, 'assistant'=> $assistant],200);

}
*/


public function addMessageToThread(Request $request){



  $thread_id=$request->thread_id;
  $content=$request->content;
  $ch = curl_init();
  $url = 'https://api.openai.com/v1/threads/'.$thread_id.'messages';
  $api_key = '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'; // replace with your key
  

  $post_fields= json_encode([
  "content"=>  $content,
  "tools"=> [["type"=> "file_search"]],
  "role"=>  "user",
  "model"=>  "gpt-4o",
  "temperature"=> 0.3
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
  return response()->json(['files'=> $response],200);
  
  }



  public function CreateAssistantThreadByQuote(Request $request)
{

  $title="devis";
  $userid=$request->userid;
  $vector_store_id=$request->vector_store_id;
  $vector_allfiles_id=$request->vector_allfiles_id;
  $category=$request->category;

  $ch = curl_init();
  $url = 'https://api.openai.com/v1/assistants';
  $api_key = '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'; // replace with your key
  

  $post_fields= json_encode([
  "instructions"=>  "Afficher le nom du contrat et le nom de la mutelle en premier.
- Recherche du montant du devis
- Calcul de la partie remboursé par la mutuelle en fonction des documents
- Calcul du reste à charge Afficher la réponse sous fome de points avec des couleur comme Chat GPT 
    ajouter des émoticônes beaucoup, Supprimer les tirets, Tu es un assistant qui répond sans jamais utiliser d'astérisques ou d'étoiles.  Supprimer les astérisques ou de hashtags, ne pas utiliser de syntaxe Markdown, 
     ajouter les lignes entière entre les paragraphes, 
    afficher à la fin la source, ajouter une formule de politesse exemple :  voici le montant de votre remboursement 
    Au plaisir de vous aider ! N’hésitez pas si vous avez d’autres questions., Si l'assitant de ne trouve pa la réponse afficher cette réponse sans formule de politesse : Désolé, je ne suis pas formé pour répondre à ce type de question. N’hésitez pas à me poser une question concernant votre contrat ou vos remboursements.
    Répondre de manière synthétique d'après le document",
  "tools"=> [["type"=> "file_search"]],
  "tool_resources"=> ["file_search"=> 
  [ "vector_store_ids"=>  [$vector_store_id]]],
  "model"=>  "gpt-4o",
  "temperature"=> 0.3
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





  $ch2 = curl_init();
  $url = 'https://api.openai.com/v1/threads';
  $api_key = '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'; // replace with your key
  
  $data = json_encode([
   "tool_resources"=>["file_search"=>["vector_store_ids"=>[$vector_store_id]]]
  ]);


  $header  = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
    'OpenAI-Beta: assistants=v2' 
  ];

  curl_setopt($ch2, CURLOPT_URL, $url);
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch2, CURLOPT_POST, 1);
  curl_setopt($ch2, CURLOPT_POSTFIELDS,  $data);
  curl_setopt($ch2, CURLOPT_HTTPHEADER, $header);

  $result2 = curl_exec($ch2);
  if (curl_errno($ch2)) {
    echo 'Error: ' . curl_error($ch2);
  }
  curl_close($ch2);
  
  $response2 = json_decode($result2);
  $thread_id= $response2->id ;
  //return $this->searchCategoryByAssistant($response->id, $thread_id);


  $assistant = new Assistant;
  $assistant->title = $title;
  $assistant->id_vector =$vector_store_id;
  $assistant->thread_id = $thread_id;
  $assistant->assitant_id = $response->id;
  $assistant->edited_by = $userid;
  $assistant->category = $category;
  $assistant->save();





 return response()->json(['assitantid'=> $response->id, 'thread_id'=> $thread_id, 'assistant'=> $assistant],200);

}







public function CompareOffreSUPP(Request $request)
{

$results=[];
$api_key = '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'; // replace with your key
$offres = [
  [
      'id' => 1,
      'name' => "Maff",
      'text' => "Offre A : Cotisation mensuelle de 85€, assistance 24h/24.",
      'embedding' => [0.1, 0.2, 0.3, 0.4]
  ],
  [
      'id' => 2,
      'name' => "Macif",
      'text' => "Offre B : Cotisation annuelle de 1020 euros.",
      'embedding' => [0.2, 0.1, 0.3, 0.5]
  ]
];


foreach ($offres as $offre) {
  $cotisation = $this->extraire_cotisation_openai($offre['text'], $api_key);

  $results[] = "Offre {$offre['name']} → Cotisation : $cotisation\n";
//  echo "Offre #{$offre['id']} → Cotisation : $cotisation\n";
}


// Retourner le résultat JSON (ex: Laravel ou autre framework)
return response()->json(['resultats' => $results], 200);


}



public function extraire_cotisation_openai($texte, $api_key) {
  $prompt = "Voici une offre d'assurance :\n\n\"$texte\"\n\nQuel est le nom de l'assurance ? Quel est le prix de la cotisation et sa fréquence (mensuelle, annuelle, etc.) ? Réponds uniquement par exemple : \"85 € par mois\" ou \"1020 euros par an\". Si aucune cotisation n'est claire, réponds : \"non précisé\".";

  $url = "https://api.openai.com/v1/chat/completions";

  $headers = [
      "Content-Type: application/json",
      "Authorization: Bearer $api_key"
  ];

  $data = [
      "model" => "gpt-4",  // ou "gpt-3.5-turbo" si tu veux limiter le coût
      "messages" => [
          ["role" => "system", "content" => "Tu es un assistant qui extrait les cotisations d'assurance."],
          ["role" => "user", "content" => $prompt]
      ],
      "temperature" => 0
  ];

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  curl_close($ch);

  $result = json_decode($response, true);

  if (isset($result['choices'][0]['message']['content'])) {
      return trim($result['choices'][0]['message']['content']);
  } else {
      return "erreur";
  }
}





public function list_offres($id, Request $request){
  $resultats = DB::table('files')
->select('id', 'category','content', 'title', 'price','company_name')
->where('edited_by', '=', $id)
//->whereNotNull('id_vector')
//->whereNotNull('category')
->get();


return response()->json( $resultats, 200);

}


public function list_offres2($id, Request $request){
  $offresCollection = DB::table('files')
->select('category','content')
->whereNotNull('id_vector')
->whereNotNull('category')
->get();

    // 2. Convertis-la en tableau PHP
    $offres = $offresCollection->toArray();  
$api_key = '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'; // replace with your key
  
$resultats = $this->extrairePrixCotisations($offres, $api_key);

return response()->json( $resultats, 200);

}







public function extrairePrixCotisations(array $offres, string $api_key): array
{
  


   // Si on reçoit une Collection, on la convertit en tableau
   if ($offres instanceof \Illuminate\Support\Collection) {
       $offres = $offres->toArray();
   }

   $resultats = [];

    foreach ($offres as $offre) {
        $texte      = $offre->content ?? '';
        $categorie  = $offre->category ?? 'Non spécifié';

        if (empty($texte)) {
            $resultats[] = [
                'category'        => $categorie,
                'prix_cotisation' => 'non spécifié'
            ];
            continue;
        }

        $prompt = "Dans ce texte d'offre d'assurance, trouve le montant de la cotisation (ex: '887,04 €') ou dis 'non spécifié' si absent :\n\n\"{$texte}\"";
        $prix   = $this->extrairePrixViaOpenAI($prompt, $api_key);

        $prompt2 = "Dans ce texte d'offre d'assurance, trouve le nom l'assurance ou mutuelle (ex: 'Macif'):\n\n\"{$texte}\"";
        $name  = $this->extraireNameViaOpenAI($prompt2, $api_key);


        $resultats[] = [
            'category'        => $categorie,
            'prix_cotisation' => $prix,
            'name' =>$name
        ];
    }

    return $resultats;
}

public function extrairePrixViaOpenAI(string $prompt, string $api_key): string
{
    $url = "https://api.openai.com/v1/chat/completions";

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ];

    $data = [
        "model" => "gpt-4",
        "messages" => [
            ["role" => "system", "content" => "Tu es un assistant qui extrait les montants des cotisations d'assurance."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['choices'][0]['message']['content'])) {
        $reponse = trim($result['choices'][0]['message']['content']);
        // Nettoyer la réponse, ex: enlever phrases inutiles, garder montant ou 'non spécifié'
        if (preg_match('/(\d+[.,]?\d*)\s*€/', $reponse, $matches)) {
            return $matches[0]; // ex: "887,04 €"
        }
        if (stripos($reponse, 'non spécifié') !== false) {
            return 'non spécifié';
        }
        // Si réponse libre, retourne quand même
        return $reponse;
    }

    return 'erreur';
}
public function extraireNameViaOpenAI(string $prompt, string $api_key): string
{
    $url = "https://api.openai.com/v1/chat/completions";

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ];

    $data = [
        "model" => "gpt-4",
        "messages" => [
            ["role" => "system", "content" => "Tu es un assistant qui extrait le nom de l'assurance.N'afficher uniquement le nom."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['choices'][0]['message']['content'])) {
        $reponse = trim($result['choices'][0]['message']['content']);
        // Nettoyer la réponse, ex: enlever phrases inutiles, garder montant ou 'non spécifié'
        if (preg_match('/(\d+[.,]?\d*)\s*€/', $reponse, $matches)) {
            return $matches[0]; // ex: "887,04 €"
        }
        if (stripos($reponse, 'non spécifié') !== false) {
            return 'non spécifié';
        }
        // Si réponse libre, retourne quand même
        return $reponse;
    }

    return 'erreur';
}



/////////////////////////

protected $openAI;

public function __construct(OpenAIService $openAI)
{
    $this->openAI = $openAI;
}




  // Extrait name et price depuis le content via OpenAI
  private function extractNamePrice(string $content): array
  {
      $prompt = "Extrait le nom de l'assurance et le prix de la cotisation du texte suivant.  
      Réponds en JSON avec ces clés : 'name' et 'price'.  
      Si l'information n'est pas trouvée, mets null.

      Texte : \"\"\"\n$content\n\"\"\"";

      $url = "https://api.openai.com/v1/chat/completions";
      $api_key = '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'; // replace wi
      $headers = [
          "Content-Type: application/json",
          "Authorization: Bearer $api_key"
      ];
    
      $data = [
          "model" => "gpt-4",  // ou "gpt-3.5-turbo" si tu veux limiter le coût
          'messages' => [
            ['role' => 'system', 'content' => "Tu es un assistant qui extrait des informations d'assurance."],
            ['role' => 'user', 'content' => $prompt],
        ],
          "temperature" => 0
      ];
    
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
      $response = curl_exec($ch);
      curl_close($ch);
    
      $result = json_decode($response, true);

      $answer = $result->choices[0]->message->content ?? '{}';
      $data = json_decode($answer, true);

 

      if (!$data) {
          return ['name' => null, 'price' => null];
      }

      return ['name' => $data['name'] ?? null, 'price' => $data['price'] ?? null];
  }



  public function CompareOffre(Request $request)
  
  {

    $apiKey = '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'; // replace wit


$user_id=$request->user_id; 
$myoffers= DB::table('files')
->select('id','category','content')
->where('edited_by',$user_id)
->whereNotNull('id_vector')
->whereNotNull('category')
->get()
->toArray(); 

// Then convert each stdClass object to an array:
$offers= array_map(function($item) {
  return (array) $item;
},   $myoffers);



  // Simule des documents issus de la base (avec category et content)
  /*
  $documents = [
      [
          'id' => 101,
          'category' => 'Mutuelle Santé',
          'content' => "Nom de la mutuelle : LMF Santé 4\nMontant : non spécifié"
      ],
      [
          'id' => 102,
          'category' => 'Assurance Emprunteur',
          'content' => "Organisme assureur : ADIS, filiale AXA\nMontant total emprunté : 329361€\nCotisation : 3516,07 €"
      ],
      [
          'id' => 103,
          'category' => 'Mutuelle Santé',
          'content' => "La Mutuelle Familiale propose une couverture hospitalisation renforcée à 887,04 €"
      ],
  ];*/
  


  $docs = DB::table('files')
->select('id','category','content')
->where('edited_by', '!=', $user_id)
->whereNotNull('id_vector')
->whereNotNull('category')
->get()
->toArray(); 


  return $docs;
}





  public function CompareOffre2(Request $request)
  
  {

    $apiKey = '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'; // replace wit
 /*   $offers = [
      [
          'category' => 'Mutuelle Santé',
          'content' => "Garanties : optique, hospitalisation Renfort Hospitalisation\nMontant des cotisations : 887,04 €\nNom : La Mutuelle Familiale"
      ],
      [
          'category' => 'Assurance Emprunteur',
          'content' => "Montant emprunté : 329361€, Durée 240 mois, Garanties : décès, invalidité, incapacité\nOrganisme : ADIS AXA"
      ],
  ];
*/




$user_id=$request->user_id; 
$myoffers= DB::table('files')
->select('id','category','content')
->where('edited_by',$user_id)
->whereNotNull('id_vector')
->whereNotNull('category')
->get()
->toArray(); 

// Then convert each stdClass object to an array:
$offers= array_map(function($item) {
  return (array) $item;
},   $myoffers);



  // Simule des documents issus de la base (avec category et content)
  /*
  $documents = [
      [
          'id' => 101,
          'category' => 'Mutuelle Santé',
          'content' => "Nom de la mutuelle : LMF Santé 4\nMontant : non spécifié"
      ],
      [
          'id' => 102,
          'category' => 'Assurance Emprunteur',
          'content' => "Organisme assureur : ADIS, filiale AXA\nMontant total emprunté : 329361€\nCotisation : 3516,07 €"
      ],
      [
          'id' => 103,
          'category' => 'Mutuelle Santé',
          'content' => "La Mutuelle Familiale propose une couverture hospitalisation renforcée à 887,04 €"
      ],
  ];*/
  


  $docs = DB::table('files')
->select('id','category','content')
->where('edited_by', '!=', $user_id)
->whereNotNull('id_vector')
->whereNotNull('category')
->get()
->toArray(); 

// Then convert each stdClass object to an array:
$documents= array_map(function($item) {
  return (array) $item;
},   $docs);


  $results = [];
  
  foreach ($offers as $offerIndex => $offer) {
   
      $offerEmbedding = $this->generateEmbeddingWithCurl($apiKey, $offer['content']);
      $similarDocs = [];
  
      foreach ($documents as $doc) {
          if ($doc['category'] !== $offer['category']) continue;
  
          $docEmbedding = $this->generateEmbeddingWithCurl($apiKey, $doc['content']);
          $similarity = $this->cosineSimilarity($offerEmbedding, $docEmbedding);
  
          $extracted = $this->extractNameAndPriceWithCurl($apiKey, $doc['content']);
  
          $similarDocs[] = [
              'id' => $doc['id'],
              'name' => $extracted['name'],
              'price' => $extracted['price'],
              'similarity' => $similarity
          ];
      }
  
      usort($similarDocs, fn($a, $b) => $b['similarity'] <=> $a['similarity']);
      $top = array_slice($similarDocs, 0, 3);
  
      foreach ($top as $match) {
        // Ajouter les résultats structurés pour cette offre
    $results[] = [
      'offer_index' => $offerIndex,
      'offer_category' => $offer['category'],
      'top_matches' => $top
  ];
      }
  
  }

  return $results;
}


function extractNameAndPriceWithCurl($apiKey, $content)
{
    $prompt = "Extrait le nom de l'assurance, le nom de l' Organisme assureur et le prix de la cotisation du texte suivant. Réponds en JSON avec les clés : name et price. Si manquant, retourne null.

Texte :
\"\"\"$content\"\"\"";

    $postData = json_encode([
        'model' => 'gpt-4o',
        'messages' => [
            ['role' => 'system', 'content' => 'Tu es un assistant pour extraire des informations d\'assurance.'],
            ['role' => 'user', 'content' => $prompt],
        ],
        'temperature' => 0,
        'max_tokens' => 150,
    ]);

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_POST => true,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);


    $jsonText = $data['choices'][0]['message']['content'] ?? '{}';


    // Extraire bloc JSON propre
    preg_match('/\{.*\}/s', $jsonText, $matches);
    $cleaned = $matches[0] ?? '{}';
    
    $result = json_decode($cleaned, true);
    
    return [
        'name' => $result['name'] ?? null,
        'assureur' => $result['assureur'] ?? null,
        'price' => $result['price'] ?? null,
    ];
}

function generateEmbeddingWithCurl($apiKey, $text)
{
    $postData = json_encode([
        'model' => 'text-embedding-3-small',
        'input' => $text
    ]);

    $ch = curl_init('https://api.openai.com/v1/embeddings');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_POST => true,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    return $data['data'][0]['embedding'] ?? [];
}

function cosineSimilarity(array $vecA, array $vecB): float
{
    $dot = $normA = $normB = 0;
    for ($i = 0; $i < count($vecA); $i++) {
        $dot += $vecA[$i] * $vecB[$i];
        $normA += $vecA[$i] ** 2;
        $normB += $vecB[$i] ** 2;
    }
    return ($normA && $normB) ? $dot / (sqrt($normA) * sqrt($normB)) : 0;
}

}

