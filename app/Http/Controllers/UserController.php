<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //

    public function add(Request $request) {

        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);
    }
    public function profileEdit(Request $request) {

        $credentials    = $request->only('name', 'title', 'gender', 'country', 'about');
        $user           = Auth::user();

        $rules = [
            'name' => 'string',
            'title' => 'string',
            'about' => 'string',
            'gender' => 'required'
        ];

        $validator = Validator::make($credentials, $rules);

        if($validator->errors()->count() > 0) {

            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        else {
            $user->name = $request->name;
            $user->title = $request->title;
            $user->about = $request->about;
            $user->gender = $request->gender;
            $user->country_id = $request->country;
            $user->save();
        }

        return response()->json([
            'success'=> true,
            'message' => 'Profile has edited!'
        ]);
    }
    public function profilePasswordChange(Request $request) {

//        dd(Auth::user());

        $credentials    = $request->only('password_old', 'password', 'password_confirmation');
        $user           = Auth::user();
        $ret            = false;

        $rules = [
            'password_old' => 'required|string',
            'password' => 'required|string|confirmed'
        ];

        $validator = Validator::make($credentials, $rules);

        if(!Hash::check( $request->password_old, Auth::user()->password )) {
            $validator->errors()->add('password_old', 'Old Password not much with current password.');
        }

        if($validator->errors()->count() > 0) {

            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        else {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json([
            'success'=> true,
            'message' => 'Password has changed!'
        ]);
    }

}
