<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
                    return response(
                        [
                            'status' => 'success',
                            'accessToken' => $user->createToken('authToken')->plainTextToken,
                            'user' => $user,
                        ],
                        Response::HTTP_OK
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
            return response(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_BAD_REQUEST);
        }
        else
        {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->sendEmailVerificationNotification();
            return response(
                [
                    'status' => 'success',
                    'message' => 'Email verification link sent on your email.',
                    'data' => $user,
                ],
                Response::HTTP_CREATED
            );
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(
            [
                'status' => 'success',
                'message' => 'Logged out successfully.',
            ],
            Response::HTTP_OK
        );
    }

    public function verify($id, Request $request)
    {
        if($request->hasValidSignature())
        {
            $user = User::findOrFail($id);

            if($user->hasVerifiedEmail())
            {
                return response(
                    [
                        'status' => 'success',
                        'message' => 'The email already verified.',
                    ],
                    Response::HTTP_OK
                );
            }
            else
            {
                $user->markEmailAsVerified();
                return response(
                    [
                        'status' => 'success',
                        'message' => 'The email verified successfully.',
                    ],
                    Response::HTTP_OK
                );
            }
        }
        else
        {
            return response(
                [
                    'status' => 'error',
                    'message' => 'Invalid or expired signature.',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function resend(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => ['required', 'email', Rule::exists('users', 'email')]]);
        
        if($validator->fails())
        {
            return response(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        else
        {
            $user = User::where('email', $request->email)->first();

            if($user->hasVerifiedEmail())
            {
                return response(
                    [
                        'status' => 'success',
                        'message' => 'The email already verified.'
                    ],
                    Response::HTTP_OK
                );
            }
            else
            {
                $user->sendEmailVerificationNotification();
                return response(
                    [
                        'status' => 'success',
                        'message' => 'Email verification link sent on your email.'
                    ],
                    Response::HTTP_OK
                );
            }
        }
    }
}
