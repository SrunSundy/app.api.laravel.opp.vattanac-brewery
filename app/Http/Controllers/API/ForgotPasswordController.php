<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Outlet\ForgotPasswordRequest;
use App\Http\Requests\API\Outlet\RequestOtpRequest;
use App\Http\Requests\API\Outlet\VerifyOtpRequest;
use App\Http\Traits\Twilio\TwilioSmsService;
use App\Models\Outlet;
use App\Models\OutletForgotCode;
use Exception;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
  
    use TwilioSmsService;
    public function requestOtpCode(RequestOtpRequest $request)
    {
        DB::beginTransaction();
        try {
            if (OutletForgotCode::isReachLimit($request->contact_number)) {
                return $this->fail(__('auth.reach_limit', ['action' => __('validation.recieve_otp')]));
            }

            $customer = OutletForgotCode::requestOtp($request->contact_number);
            DB::commit();

            $this->sendSMSVerification($request->contact_number, $customer->verify_code);
            return $this->ok([
                'contact_number' => $request->contact_number,
                'expired_in' => 10,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function verifyOtpCode(VerifyOtpRequest $request)
    {
        DB::beginTransaction();
        try {
            if (!$token = OutletForgotCode::verifyOtp($request->contact_number, $request->otp)) {
                return $this->fail(__('validation.invalid', ['attribute' => __('validation.attributes.otp')]));
            }
            DB::commit();

            return $this->ok([
                'contact_number' => $request->contact_number,
                'forgot_password_token' => $token,
            ], '');
        } catch (Exception $e) {
            DB::rollback();
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function resetPassword(ForgotPasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            if (!$customer = Outlet::forgotPassword($request)) {
                return $this->fail(__('validation.expired', ['attribute' => __('validation.attributes.session')]));
            }

            DB::commit();
            
            return $this->ok(null, __('dialog.success', ['action' => __('dialog.action.reset_your_password')]));
        } catch (Exception $e) {
            DB::rollback();
            return $this->fail($e->getMessage(), 500);
        }
    }
}
