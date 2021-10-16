<?php

namespace App\Models;

use App\Core\DateLib;
use App\Http\Traits\ModelHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OutletForgotCode extends Model
{
    use SoftDeletes, ModelHelperTrait;

    protected $fillable = [
        'phone_number',
        'verify_code',
        'forgot_token',
        'is_verify',
        'expired_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeVerify($query, $is_verify = true)
    {
        return $query->where('is_verify', $is_verify);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function isReachLimit($phone_number)
    {
        $today_sent = self::where('phone_number', $phone_number)
            ->whereDate('created_at', DateLib::getNow())
            ->withTrashed()
            ->count();

        return $today_sent >= 3;
    }

    public static function createVerifyCode($phone_number, $is_verify = 0)
    {
        return self::create([
            'phone_number' => $phone_number,
            'verify_code' => randomDigits(4),
            'is_verify' => $is_verify,
            'expired_at' => DateLib::getNow()->addMinutes(10)->toDateTimeString()
        ]);
    }

    public static function requestOtp($phone_number)
    {
        $customer_verify_code = self::where('phone_number', $phone_number)
            ->where('expired_at', '>', DateLib::getNow())->first();

        if ($customer_verify_code) {
            $customer_verify_code->update([
                'expired_at' => DateLib::getNow(),
            ]);
        }

        return self::createVerifyCode($phone_number);
    }

    public static function verifyOtp($phone_number, $otp)
    {
        $customer_verify_code = self::where('phone_number', $phone_number)
            ->where('expired_at', '>', DateLib::getNow())
            ->where('verify_code', $otp)
            ->verify(false)
            ->first();
        if (!$customer_verify_code) {
            return false;
        }
        $token = Str::uuid();

        $customer_verify_code->update([
            'forgot_token' => $token,
            'is_verify' => true,
            'expired_at' => DateLib::getNow()->addMinutes(10)->toDateTimeString(),
        ]);

        return $token;
    }

    public static function verifyForgotPasswordToken($request)
    {
        $customer_verify_code = self::where('phone_number', $request->contact_number)
            ->where('expired_at', '>', DateLib::getNow())
            ->where('forgot_token', $request->forgot_password_token)
            ->first();

        if (!$customer_verify_code) {
            return false;
        }
        $data = clone $customer_verify_code;

        $customer_verify_code->update([
            'is_verify' => true,
            'expired_at' => DateLib::getNow(),
        ]);

        return $data;
    }
}
