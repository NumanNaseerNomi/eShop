<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => ['required', 'email'], 'password' => ['required']]);

        if($validator->fails())
        {
            return response(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        else
        {
            if(Auth::attempt($request->all()))
            {
                $data =
                [
                    'user' => auth()->user(),
                    'access_token' => auth()->user()->createToken('authToken')->accessToken
                ];

                return response($data, Response::HTTP_OK);
            }

            return response(['message' => 'The provided credentials do not match our records.'], Response::HTTP_FORBIDDEN);
        } 
    }

    public function register(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->sendEmailVerificationNotification();

        return response($user, Response::HTTP_CREATED);
    }

    public function logout()
    {
        if(Auth::check())
        {
            Auth::user()->OauthAccessToken()->delete();
            return response(['message' => 'Logout successfully.'], Response::HTTP_OK);
        }

        return response(['message' => 'Logout'], Response::HTTP_OK);
    }

    public function verify($id, Request $request)
    {
        if(!$request->hasValidSignature())
        {
            return response(254, 401);
        }

        $user = User::findOrFail($id);

        if(!$user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();
        }

        return response(['message' => 'The email verified successfully.'], Response::HTTP_OK);
    }

    public function resend()
    {
        if(Auth::user()->hasVerifiedEmail())
        {
            return response(['message' => 'The email is already verified.'], Response::HTTP_FORBIDDEN);
        }
        else
        {
            Auth::user()->sendEmailVerificationNotification();
            return response(['message' => 'Email verification link sent on your email.'], Response::HTTP_OK);
        }
    }

    public function notice()
    {
        return response(['message' => 'The email must be verified.'], Response::HTTP_OK);

        if(Auth::user()->hasVerifiedEmail())
        {
            return response(['message' => 'The email is already verified.'], Response::HTTP_FORBIDDEN);
        }
        else
        {
            Auth::user()->sendEmailVerificationNotification();
            return response(['message' => 'Email verification link sent on your email.'], Response::HTTP_OK);
        }
    }
}
