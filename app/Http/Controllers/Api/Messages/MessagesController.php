<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Models\Messages;
use Illuminate\Support\Facades\Mail;
use App\Mail\Message;
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
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $email = $request->email;
        $name = $request->name;
        $type = $request->type;
        $phone = $request->phone;
        $recipients = [
            "sales@unifreightco.com",
            "aizhan.kussainova@unifreightco.com",
            "olzhasalidarov@gmail.com",
            "aruzhan.bessetova@unifreightco.com",
            "test@unifreightco.com",
            "venera.turgaliyeva@unifreightco.com",
            "venera.turgaliyeva@mail.ru",
        ];
        Mail::to($recipients)->send(new Message($email, $name, $type, $phone));
        $message = Messages::create(['name' => $request->name, 'email' => $request->email, 'type' => 'no-type', 'phone' => $request->phone]);
        return response()->json(['success' => true, $message], 200);
    }
}
