<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Models\Messages;
use Validator;

class MessagesController extends Controller
{
    public function messages()
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
        $array = Messages::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }

    public function messageSave(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $message = Messages::create(['name' => $request->name, 'email' => $request->email, 'subject' => $request->subject, 'phone' => $request->phone]);
        return response()->json(['success' => true, $message], 201);
    }
}
