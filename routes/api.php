<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::middleware('auth:api')->group(function() {
    Route::namespace('Api')->group(function() {


   
     //AUTH 
     Route::post('/profil', 'AuthController@profil');
     Route::post('/change_password/{id}', 'AuthController@change_password');
     Route::post('adduser', 'AuthController@adduser');
  
     ///USERS
     Route::apiResource('users','UsersController');
     Route::get('/userByrole', 'UsersController@userByrole');
  
     ///POSTS
     Route::apiResource('posts', 'PostsController');
     Route::get('/posts/posts_user/{id_user}', 'PostsController@postsByUser');
     Route::get('/posts/posts_user/{id_user}', 'PostsController@postsByUser');
     Route::get('/posts/posts_user_short/{id_user}', 'PostsController@postsByUserShort');
     Route::get('/postnotes/{id}', 'PostsController@postnotes');
     Route::post('postnotation', 'PostsController@postnotation');
     ///GALLERY

     ////PAGES
     Route::apiResource('pages','PagesController');
  
  
     //PROJETS
     Route::apiResource('projects','ProjectsController');
     Route::get('/projects_byuser/{id}', 'ProjectsController@allprojects');
  
 
  
     // NOTIFS
     Route::apiResource('notifs','NotifsController');
  
     ///UPLOAD
     Route::post('upload', 'GalleryController@upload');
     Route::post('uploadgalleryimage', 'GalleryController@uploadGalleryImage');
  

     /// UPDATE USER AVATAR BASE64
     Route::put('/user_avatar/{id}', 'UsersController@updateAvatar');
  
     //THREADS
     Route::apiResource('threads', 'ThreadsController');
     Route::get('threads_user_id/{id_user}', 'ThreadsController@threadByuser');

  
  
     //EMAILS
     Route::post('sendrdv', 'EmailsController@sendrdv');
     Route::post('sendform1', 'EmailsController@sendform1');
     Route::get('/sendmail', 'MailController@sendmail');
     Route::post('savepdfwithoutemail', 'EmailsController@savepdfwithoutemail');
  
     /////EMAIL AUTOMATIQUES
     Route::get('/appointementonemonth', 'AppointementsController@AllAppointementOneMonth');
     Route::get('/appointementtowmonth', 'AppointementsController@AllAppointementTowMonth');
     Route::get('/allinvoicesclose', 'InvoicesController@Allinvoicesclose');
  
  

     Route::get('/public_count', 'PostsController@public_count');
     Route::get('/projetscount', 'ProjectsController@postscount');   
       
      
  
     Route::post('/getlocation', 'AppointementsController@getlocation');
     Route::post('/saveappointement', 'AppointementsController@saveappointement');
     Route::get('/gallerieBypost/{id}', 'AppointementsController@gallerieBypost');
         
     Route::post('/public_location_posts', 'LocationController@public_location_posts');

     Route::get('/public_location_detail/{id}', 'LocationController@public_location_detail');
     Route::get('/public_posts_short', 'PostsController@public_posts_short');

     Route::get('/public_post/{id}', 'PostsController@public_post');

     Route::get('/tags_bylocation/{id}', 'LocationController@tags_bylocation');
     Route::apiResource('locations', 'LocationController');
     Route::apiResource('tagslocations', 'TagslocationController');
     Route::apiResource('favoris', 'FavorisController');
     Route::get('/checkfavoris', 'FavorisController@checkfavoris');
  
  
     Route::post('/searchCategoryByFileId', 'LocationController@searchCategoryByFileId');
     Route::post('/searchDataByFileId', 'LocationController@searchDataByFileId');
     Route::post('/createAssitantByCategory', 'LocationController@createAssitantByCategory');
     Route::post('/CreateAssistantThreadByFile', 'LocationController@CreateAssistantThreadByFile');
     Route::post('/CreateAssistantThreadByQuote', 'LocationController@CreateAssistantThreadByQuote');

     /////Files
     Route::apiResource('files','FilesController');
     Route::get('/filesByUser/{id_user}', 'FilesController@filesByUser');
     Route::get('/list_offres/{id_user}', 'LocationController@list_offres');

    ///// Assistants
     Route::apiResource('assistants','AssistantsController');
     Route::get('/assitantsByUser/{id_user}', 'AssistantsController@filesByUser');


     Route::post('/askdoc', 'FilesController@askdoc');
     Route::post('/languagetool', 'PostsController@languagetool');


     Route::get('/public_chatgpt/{id}', 'LocationController@public_chatgpt');
     Route::post('/newthread_chatgpt', 'LocationController@newthread_chatgpt');
     Route::post('/addmessage_chatgpt', 'LocationController@addmessage_chatgpt');


     Route::post('/addMessageToThread', 'LocationController@addMessageToThread');
     Route::get('/public_assitant_files', 'LocationController@public_assitant_files');


     Route::post('/public_assitant_uploadFromUrlToCurl', 'LocationController@public_assitant_uploadFromUrlToCurl');
     Route::post('/public_assitant_uploadfile', 'LocationController@public_assitant_uploadfile');
     Route::post('/vector_store_file', 'LocationController@vector_store_file');
     Route::post('/assitant_create', 'LocationController@assitant_create');


     //assitant_create_withoutfile
     Route::post('/assitant_create_withoutfile', 'LocationController@assitant_create_withoutfile');

     Route::post('/CompareOffre', 'LocationController@CompareOffre');
   
     });
});

Route::namespace('Api')->group(function() {




  Route::get('/searchadress','AuthController@searchAdress');

  Route::get('/public_tags', 'TagsController@public_tags');
  Route::get('/public_locations_short', 'LocationController@public_locations_short');
  
  Route::post('/public_location', 'LocationController@public_location');
  Route::post('/public_location_map', 'LocationController@public_location_map');
  //////


        Route::post('/login', 'AuthController@login');
        Route::post('/register','AuthController@register');
        Route::post('/registersocial','AuthController@registersocial');
        Route::post('/verifywithcode', 'VerificationApiController@verifywithcode');
        //Route::post('logout', 'AuthController@logout');

        Route::post('/forgotpassword', 'AuthController@resetpassword');
        Route::apiResource('tags', 'TagsController');
        Route::get('email/verify/{id}','VerificationApiController@verify')->name('verificationapi.verify');
        Route::get('email/resend','VerificationApiController@resend')->name('verificationapi.resend');
        Route::get('/verify/{token}', 'VerificationApiController@VerifyEmail');
        Route::post('testemail', 'EmailsController@testemail');
   


        /////XML
        Route::get('/sitemap-posts.xml', 'SitemapController@posts');


        Route::get('/clear-cache', function() {
          $exitCode = Artisan::call('cache:clear');
          // return what you want
        });

        });


          