<?php

namespace App\Api\V1\Controllers\Auth;

use Auth;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Api\V1\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class LoginController extends Controller
{
    /**
     * Log the user in.
     *
     * @param LoginRequest $request
     * @param JWTAuth      $JWTAuth
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = $JWTAuth->attempt($credentials);

            if (! $token) {
                throw new AccessDeniedHttpException();
            }
        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        activity()
           ->causedBy(auth()->user()->id) //causer_id and causer_type
           ->performedOn(auth()->user()) //subject_type
           ->withProperties(['key' => 'value']) //properties
           ->log('User Login'); //log description

        return response()
            ->json([
                'status' => 'ok',
                'token' => $token,
                'expires_in' => Auth::guard()->factory()->getTTL() * 60,
            ]);
    }
}
