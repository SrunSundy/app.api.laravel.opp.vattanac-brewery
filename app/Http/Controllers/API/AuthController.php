<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\ProfileResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!$token = Auth::attempt([
            'contact_number' => $request->phone_number,
            'password' => $request->password,
        ])) {
            return $this->fail(__('validation.incorrect', ['attribute' => __('validation.attributes.phone_number_or_password')]), 401);
        }

        return $this->ok($this->respondWithToken($token));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return $this->ok('', __('dialog.success', ['action' => __('dialog.action.logout')]));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->ok($this->respondWithToken(Auth::refresh()));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return $this->ok(new ProfileResource(auth()->user()));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => config('api.credential.token_type'),
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
