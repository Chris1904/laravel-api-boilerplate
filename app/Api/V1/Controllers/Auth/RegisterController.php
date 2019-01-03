<?php

namespace App\Api\V1\Controllers\Auth;

use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, JWTAuth $JWTAuth)
    {
        $user = $request->users()->add();

        if (! config('boilerplate.sign_up.release_token', false)) {
            return response()->json([
                'status' => 'ok',
            ], 201);
        }

        return response()->json([
            'status' => 'ok',
            'token' => $JWTAuth->fromUser($user),
        ], 201);
    }
}
