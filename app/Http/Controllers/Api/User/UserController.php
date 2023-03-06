<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Models\Emails;
use App\Models\Models\Phones;
use App\Models\Models\Notifications;
use Auth;
use Illuminate\Support\Facades\Hash;

use Validator;

class UserController extends Controller
{
    public function allUsers()
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        if (auth()->user()->admin == 1) {
            return User::all();
        } else {
            return response()->json(['success' => false, 'error' => 'You are not admin'], 401);
        }
    }

    public function userData()
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        return Auth::user();
    }

    public function userRegistration(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'lastname' => 'required',
            'patro' => 'required',
            'password_confirmation' => 'required'
        ];

        $input = $request->only('name', 'email', 'password', 'phone', 'password_confirmation', 'lastname', 'patro');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        if ($request->password === $request->password_confirmation) {
            $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'admin' => false, 'patro' => $request->patro, 'lastname' => $request->lastname]);
        } else {
            return response()->json(['success' => false, 'error' => "Data didn't match"]);
        }
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function updateUserInfo(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        User::where('id', auth()->user()->id)->update(array(
            'name' => $request->name,
            'lastname' => $request->lastname,
            'patro' => $request->patro,
            'iin' => $request->iin,
        ));
        return response()->json(['success' => true, "data" => "Data updated successfully"], 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
        $hashedPassword = auth()->user()->password;
        if (Hash::check($request->cur_pass, $hashedPassword)) {
            User::where('id', auth()->user()->id)->update(array(
                'password' => Hash::make($request->password),
            ));
            return response()->json(['success' => true, "data" => "Password updated"], 200);
        } else {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true, "data" => "Data updated successfully"], 200);
    }
}
