<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     "name" => 'required|string',
        //     "email" => 'required|email|unique:users',
        //     "password" => 'required|confirmed|min:6',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => "validation failed",
        //         'errors' => $validator->errors()
        //     ]);
        // }
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => "Post created successfully",
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
