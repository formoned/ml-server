<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;

class ApiRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
    }

    protected function create(Request $request)
    {
        $credentials = $request->only('email', 'password', 'password_confirmation');

        $rules = [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);

        if($validator->fails()) {

            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $email = $request->email;
        $password = $request->password;

        $user = User::create(['email' => $email, 'password' => bcrypt($password)]);

        $verification_code = str_random(30); //Generate verification code

        DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);

        $subject = "Please verify your email address.";

        Mail::send('email.verify', ['email' => $email, 'verification_code' => $verification_code],
            function($mail) use ($email, $subject){
                $mail->from(env('MAIL_USERNAME'), "From User/Company Name Goes Here");
                $mail->to($email, $email);
                $mail->subject($subject);
            });

        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);

//        return User::create([
//            'email' => $request->email,
//            'password' => bcrypt($request->password),
//        ]);
    }
}