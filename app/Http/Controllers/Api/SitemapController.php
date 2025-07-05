<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class SitemapController extends Controller
{

    public function index()
    {
      $posts = Post::all()->first();
      return response()->view('sitemap.index', [
          'posts' => $posts,
      ])->header('Content-Type', 'text/xml');
    }



    public function posts()
    {
        $posts = Post::latest()->get();
        return response()->view('sitemap', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml');
    }

    public function posts2()
    {
        $data = DB::table('projects')
        ->select(DB::raw('count(*) as da_count, da'))
        ->orderBy('created_at','desc')
        ->groupBy('da')
     //   ->limit(30)
        ->get();


   return response()->json(
       ['da'=>$data],200);
    }



    
}
