<?php

namespace App\Http\Controllers\Admin\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function __construct(){

    }

    // --------------- { Register } ---------------------
    function register(Request $request){
        // Validations Request
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create User In Database
        $user = Admin::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Generate Token For Register User
        $token = $user->createToken('auth_token')->accessToken;

        // Return Response
        return response()->json([
            'user' => $user,
            'access_token' => $token
        ], 201);
    }

    // --------------- { Login } ---------------------
    function login(Request $request){
        // Validations Request
        $validatedData = $request->validate([
            'email'    =>['required','string','max:255','email','exists:admins,email'],
            'password' => ['required','string']
        ]);

        // Get This User
        $user = Admin::where('email', $validatedData['email'])->first();

        // Check Password And Login
        if(!$user || !Hash::check($validatedData['password'], $user->password)){
            return response()->json(['message'=>'Invalid Credentials'], 401);
        }


        // Generate Token For Login User
        $token = $user->createToken('auth_token')->accessToken;

        // Return Response
        return response()->json([
            'user' => $user,
            'access_token' => $token
        ],200);
    }
}
