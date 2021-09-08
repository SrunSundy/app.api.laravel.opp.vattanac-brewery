<?php

namespace App\Http\Middleware;

use App\Core\DateLib;
use App\Core\EncryptLib;
use App\Http\Traits\ResponseTrait;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class ApiAuthorizationnMiddleware
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authorization = explode(" ", request()->header('Authorization'));
        if (count($authorization) !== 2) {
            return $this->fail(__('auth.unauthorized'), 403, 100);
        }

        $decrypted = explode("[-]", EncryptLib::decryptString($authorization[1] ?? '', Setting::getValueByKey('api.credential.cipher.password'), Setting::getValueByKey('api.credential.cipher.iv')));
        $variance = (int) Setting::getValueByKey('api.credential.cipher.variance');
        if (count($decrypted) !== 2) {
            return $this->fail(__('auth.unauthorized'), 403, 100);
        }

        if (DateLib::getSecondFromTimeStamp($decrypted[1]) > $variance) {
            return $this->fail(__('auth.unauthorized'), 403, 101);
        }

        request()->headers->set('Authorization', $authorization[0] . ' ' . $decrypted[0]);

        return $next($request);
    }
}
