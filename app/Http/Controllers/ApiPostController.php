<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApiPostController extends Controller
{
    public function SaveNewPost(Request $request) {
        $credentials    = $request->only('title', 'description', 'lat', 'lng');
        $user           = Auth::user();

        $rules = [
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:480',
            'lat' => 'required',
            'lng' => 'required'
        ];

        $validator = Validator::make($credentials, $rules);

        if($validator->errors()->count() > 0) {

            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        else {

//            $lat = $request->lat;
//            $lng = $request->lat;
            $post = new Post();
            $post->title        = $request->title;
            $post->description  = $request->description;
            $post->lat          = $request->lat;
            $post->lng          = $request->lng;
            $post->created_by   = $user->id;
            $post->created_at   = Carbon::now();
            $post->updated_at   = Carbon::now();
            $post->save();
        }

        return response()->json([
            'success'=> true,
            'message' => 'Posts has added!'
        ]);
    }

    public function EditPost(Request $request) {
        $credentials    = $request->only('id', 'title', 'description', 'lat', 'lng');
        $user           = Auth::user();

        $rules = [
            'id' => 'required',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:480',
            'lat' => 'required',
            'lng' => 'required'
        ];

        $validator = Validator::make($credentials, $rules);

        if($validator->errors()->count() > 0) {

            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        else {


            $post = Post::where('id', $request->id)->where('created_by', $user->id)->first();

            if(isset($post)) {

                $post->title        = $request->title;
                $post->description  = $request->description;
                $post->lat          = $request->lat;
                $post->lng          = $request->lng;
                $post->updated_at   = Carbon::now();
                $post->save();
            }
            else {
                return response()->json(['success'=> false, 'message' => 'Could not find this post!']);
            }
        }

        return response()->json([
            'success'=> true,
            'message' => 'Posts has edited!'
        ]);
    }
}
