<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Models\Products;

use Validator;

class ProductsController extends Controller
{
    public function products()
    {
        $array = Products::all();
        $data_1 = collect($array)->all();

        return response()->json(['data' => $data_1], 200);
    }

    public function productSave(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
        $rules = [
            'title' => 'required|min:3',
            'imageUrl' => 'required|min:2',
            'contentSet' => 'required|min:2',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, $validator->errors()], 400);
        }
        $post = Products::create(['title' => $request->title, 'imageUrl' => $request->imageUrl, 'content' => $request->contentSet]);
        return response()->json(['success' => true, $post], 201);
    }

    public function productById($id)
    {
        $post = Products::find($id);
        if (is_null($post)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        return response()->json(Products::find($id), 200);
    }

    public function productEdit(Request $req, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
        $rules = [
            'title' => 'required|min:3',
            'imageUrl' => 'required|min:2',
            'contentSet' => 'required|min:2'
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $product = Products::find($id);
        if (is_null($product)) {
            return response()->json(['error' => true, 'message' => 'object not found'], 404);
        }
        $product->update(['title' => $req->title, 'imageUrl' => $req->imageUrl, 'content' => $req->contentSet]);
        return response()->json($product, 200);
    }
}
