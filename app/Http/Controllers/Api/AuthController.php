<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Method for user login
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        
        try {
            // Validate user credentials
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
            
            // Get the user based on the provided name/email
            $user = User::where('name', $request->input('name'))->first();
            
            // Check if user exists and retrieve the role
            if ($user) {
                $role = $user->role; // Assuming 'role' is the column name in the users table
                
                // Add user's role to the JWT token claims
                $token = JWTAuth::claims(['role' => $role])->attempt($credentials);
            }
            // $payload = JWTAuth::getPayload($token)->toArray();
            
            // Extract the role from the payload
            // $role = $payload['role'] ?? null;

            // if ($role) {
            //     return response()->json(['role' => $role]);
            // }
            // Return the token in the response
            return response()->json([
                'token' => $token,
                'role' => $role
            ]);
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    }

    // Method for user logout
    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'user_not_found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'token_invalid'], 500);
        }

        return response()->json($user);
    }

    // Method for refreshing a token
    public function refresh() {
        return response()->json([
            'token' => auth()->refresh(),
            
        ]);
    }
}
