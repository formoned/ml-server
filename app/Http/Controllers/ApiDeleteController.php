<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApiDeleteController extends Controller
{
    public function DeleteUserPost($id) {

        $user = Auth::user();

        $post = Post::where('id', $id)->first();

        if(isset($post)) {

            if($post->created_by == $user->id) {

                $ret = $post->delete();

                return response()->json(['success'=> $ret, 'message' => 'Post has deleted successfully']);
            }
            else {

                return response()->json(['success'=> false, 'message' => 'No access to delete this post!']);
            }
        }

        return response()->json(['success'=> false, 'message' => 'Could not find this post!']);

    }
}
