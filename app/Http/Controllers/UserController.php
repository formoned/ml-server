<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    //

    public function add(Request $request) {

        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);
    }

}
