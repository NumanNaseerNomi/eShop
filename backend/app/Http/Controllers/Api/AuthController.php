<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(auth()->attempt($request->all()))
        {
            $data =
            [
                'user' => auth()->user(),
                'access_token' => auth()->user()->createToken('authToken')->accessToken
            ];

            return response($data, Response::HTTP_OK);
        }

        return response([
            'message' => 'This User does not exist'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
