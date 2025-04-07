<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        if ((new User)->isEmailAlreadyUsed($request->email)) {
            return $this->errorResponse('Email already in use', 422);
        }

        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->showMessage($response, 201);
    }

    public function login(Request $request)
    {
        if ((new User)->isPasswordLess($request->password)) {
            return $this->errorResponse('Password must be at least 6 characters', 422);
        }

        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return $this->errorResponse('Bad credentials', 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->showMessage($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->showMessage('Logged out successfully');
    }
}
