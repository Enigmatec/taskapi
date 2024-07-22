<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "email" => ['required', 'email:filter'],
            "password" => ['required']
        ]);

        if(!Auth::attempt($validated)){
            return response()->json([
                "status" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            "status" => true,
            "message" => "Login Successful",
            "Authorization" => [
                "bearer" => $token
            ]
        ]);
    }
}
