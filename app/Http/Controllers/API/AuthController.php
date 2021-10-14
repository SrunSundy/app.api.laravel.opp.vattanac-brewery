<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdatePasscodeRequest;
use App\Http\Resources\API\Auth\ProfileResource;
use App\Models\Outlet;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            return $this->fail(__('validation.incorrect', ['attribute' => __('validation.attributes.phone_number_or_password')]));
        }
        $data = $this->respondWithToken($token);
        $data["user"] =  Auth::user();
        return $this->ok($data);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return $this->ok(null, __('dialog.success', ['action' => __('dialog.action.logout')]));
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
        $detail = $this->ok(new ProfileResource(auth()->user()));
        return $detail;
    }

    /**
     * Get the authenticated User.
     *
     * @param UpdatePasscodeRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasscodeRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($user = Auth::attempt([
                'contact_number' => auth()->user()->contact_number,
                'password' => $request->old_password,
            ])) {
                $outlet = Outlet::find(auth()->user()->id);
                $outlet->password = $request->password;
                $outlet->save();

                DB::commit();
                return $this->ok(null, __('dialog.success', ['action' => __('dialog.action.update_your_password')]));
            }
            return $this->fail(__('validation.incorrect', ['attribute' => __('validation.attributes.old_password')]));
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            return $this->fail(__('auth.failed'));
        }
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
