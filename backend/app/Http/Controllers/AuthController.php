<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            return response(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        else
        {
            if(Auth::attempt($request->all()))
            {
                $user = $request->user();
                
                if($user->hasVerifiedEmail())
                {
                    return response()->json(
                        [
                            'status' => 'success',
                            'accessToken' => $user->createToken('authToken')->plainTextToken,
                            'user' => $user,
                        ]
                    );
                }
                else
                {
                    Auth::logout();
                    return response(
                        [
                            'status' => 'error',
                            'message' => 'Your email address has not been verified.',
                        ],
                        Response::HTTP_UNAUTHORIZED 
                    );
                }
            }
            else
            {
                return response(
                    [
                        'status' => 'error',
                        'message' => 'The provided credentials do not match our records.',
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }
        }
    }

    public function register(Request $request)
    {
        // dd(11);
        $validationRules =
        [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'address' => ['required'],
            'password' => ['required', 'confirmed', 'min:5'],
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if($validator->fails())
        {
            return response(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        else
        {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            // $user->sendEmailVerificationNotification();

            // return response($user, Response::HTTP_CREATED);
            return response(['message' => 'Email verification link sent on your email.', 'data' => $user], Response::HTTP_CREATED);
        }
    }
}
