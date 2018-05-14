<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiGetController extends Controller
{
    public function CountriesList() {


        $list = DB::table('countries')->orderBy('name')->get(['id', 'name']);

        return response()->json(['success'=> true, 'list'=> $list]);

    }

    public function UserPosts() {


        $posts = DB::table('posts')->where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return response()->json(['success'=> true, 'posts'=> $posts]);

    }
    public function UserPostById($_id) {

        $posts = DB::table('posts')->where('created_by', Auth::user()->id)->where('id', $_id)->first();

        return response()->json(['success'=> true, 'posts'=> $posts]);

    }
    public function UserPostsMarkers() {


        $posts = DB::table('posts')->where('created_by', Auth::user()->id)->orderBy('created_at', 'asc')->get(['id', 'title', 'lat', 'lng', 'created_at']);

        return response()->json(['success'=> true, 'posts'=> $posts]);

    }
}
