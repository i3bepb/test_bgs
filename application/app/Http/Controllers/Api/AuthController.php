<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public $successStatus = 200;

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(LoginRequest $request)
    {
        try {
            $password = $request->get('password');
            $email = $request->get('email');
            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'status_code' => 401,
                    'message'     => 'Unauthorized'
                ], 401);
            }
            $user = Auth::user();
            $user->tokens()->delete();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code'  => 200,
                'access_token' => $tokenResult,
                'token_type'   => 'Bearer',
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error: ' . $error->getMessage(),
            ], 500);
        }
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $userData = $request->only([
            'name',
            'email',
        ]);
        $userData['password'] = bcrypt($request->get('password'));
        User::create($userData);
        return response()->json([
            'status_code' => 200,
            'message'     => 'Create user successful',
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status_code' => 200,
            'message'     => 'Successfully logged out'
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorized()
    {
        return response()->json([
            'status_code' => 401,
            'message'     => 'Unauthorized'
        ], 401);
    }
}
