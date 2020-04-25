<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->username;
        $password = bcrypt($request->password);
        $user = User::where('name', $username)
            ->where('password', $password)
            ->first();
        $token = Hash::make($request->password);
        if ($user)
        {
            $user->api_token = $token;
            $user->save();
            return response()->json(['token' => $token], 200);
        }else{
            return response()->json(['status' => 'Username Or Password is Wrong'], 403);
        }
    }
}
