<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Неправильный логин или пароль'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return new LoginResource([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function showUser(Request $request) {
        return new UserResource($request->user());
    }
}
