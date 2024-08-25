<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * login
     *
     * @param LoginRequest $request 
     *
     * @return response  of the status of operation : message the user data and the token
     */
    public function login(LoginRequest $request)
    {
        $loginData = $request->all();

        $user = User::where('email', '=',  $loginData['email'])->first();
        if (!$user || !Hash::check($loginData['password'], $user->password)) {
            return response()->json([
                'message' => 'invalid data',
            ], 401);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        $user = UserResource::make($user);

        return response()->json([
            'message' => 'logged in successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * logout
     *
     * @param Request $request 
     *
     * @return response  of the status of operation : message 
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            "message" => 'logout successfully '
        ], 200);
    }
    /**
     * logout
     *
     * @param RegisterRequest $request 
     *
     * @return response  of the status of operation : message the user data and the token
     */
    public function register(RegisterRequest $request)
    {
        $registerData = $request->all();
        $registerData['password'] = Hash::make($registerData['password']);
        $registerData['role'] = 1;

        $user = User::create($registerData);

        $token = $user->createToken('api-token')->plainTextToken;
        $user = UserResource::make($user);

        return response()->json([
            "message" => 'registration successful',
            "user" => $user,
            "token" => $token,
        ], 201);
    }
}
