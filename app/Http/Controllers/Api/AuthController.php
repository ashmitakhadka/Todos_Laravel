<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);


        // Automatically log the user in
        Auth::login($user);

        // Regenerate session after login
        $request->session()->regenerate();


        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user,
        ], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
            ],
        ]);


        if (!Auth::attempt($credentials)) {

            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }


        $request->session()->regenerate();


        return response()->json([
            'message' => 'Login successful.',
            'user' => Auth::user(),
        ]);
    }

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json([
        'message' => 'Logout successful.'
    ]);
}
}