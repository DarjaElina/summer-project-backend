<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthUser extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Cannot validate the input",
                "error" => $validator->errors()->all()
            ], 300);
        }
        $data = User::create(['name' => $request->name, 'email' => $request->email, 'password' => $request->password]);
        return response()->json([
            'status' => true,
            'message' => "User created successfully",
            'user' => $data,
        ], 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Cannot validate the Credentials",
                "error" => $validator->errors()->all()
            ], 300);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'message' => "User Logged In  successfully",
                'token' => $user->createToken('API Token')->plainTextToken,
                'token_type' => 'bearer'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Error while Login",
                "error" => $validator->errors()->all()
            ], 304);
        }
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => "Log out Successful",
        ], 200);
    }
}
