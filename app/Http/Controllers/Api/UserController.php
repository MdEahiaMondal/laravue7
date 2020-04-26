<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['name' => $request->username, 'password' => $request->password])) {
            $token = Str::random(40);
          Auth::user()->api_token = $token;
            Auth::user()->save();
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['status' => 'Username Or Password is Wrong'], 403);
        }
    }

}
