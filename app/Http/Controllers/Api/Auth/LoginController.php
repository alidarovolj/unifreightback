<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($creds)) {
            return response()->json(['success' => false, 'error' => 'Incorrect Login or Password', 401]);
        }
        return response()->json(['success' => true, 'token' => $token]);
    }

    public function refresh()
    {
        try {
            $token = auth()->refresh();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        return response()->json(['success' => true, 'token' => $token]);
    }
}
