<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// CLOUDINARY_URL=cloudinary://516533875166862:kv-QmS0vBQcQoMR-n9hIppxZ5fI@dy0k0hjzv

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
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'User with this email already exists.',
                'error' => ['Email already in use.']
            ], 409);
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
                'message' => "Validation failed",
                'errors' => $validator->errors()->all()
            ], 422);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'message' => "User Logged In  successfully",
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken,
                'token_type' => 'bearer'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Incorrect email or password",
                'errors' => ['Incorrect email or password']
            ], 401);
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
