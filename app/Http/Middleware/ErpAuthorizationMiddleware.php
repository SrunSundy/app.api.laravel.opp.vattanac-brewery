<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Core\EncryptLib;
use App\Core\DateLib;


class ErpAuthorizationMiddleware
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
        $required_text = $this->checkRequiredHeader(['Grant-Type', 'Client-Id', 'Client-Secret', 'Authorization']);
        if (filled($required_text)) {
            return $this->fail(__('validation.required', ['attribute' => $required_text]), 400);
        }

        if (!$this->checkHeaderValue(['Grant-Type', 'Client-Id', 'Client-Secret'])) {
            return $this->fail(__('auth.unauthorized'), 403);
        }

        $authorization = explode(" ", request()->header('Authorization'));
        if (count($authorization) !== 2 || $authorization[0] !== config('erp.credential.token_type')) {
            return $this->fail('Authorization requires Bearer', 403);
        }

        $decrypted = explode( "-", EncryptLib::decryptString($authorization[1] ?? ''));
        $variance = (int) config('erp.credential.cipher.variance');
        if(count($decrypted) !== 3) {
            return $this->fail(__('auth.unauthorized'), 403);
        }

        if (!$this->checkEncryptValue(['Client-Id' => $decrypted[0], 'Client-Secret' => $decrypted[1]])) {
            return $this->fail(__('auth.unauthorized'), 403);
        }

        if (DateLib::getSecondFromTimeStamp($decrypted[2]) > $variance) {
            return $this->fail(__('auth.unauthorized'), 403);
        }

        return $next($request);
    }

    protected function checkRequiredHeader($headers = [])
    {
        $required_text = '';
        foreach ($headers as $index => $header) {
            $header_value = request()->header($header);

            if (!filled($header_value)) {
                if ($index < count($headers) - 1) {
                    $required_text .=  "$header, ";
                } else {
                    $required_text .=  "$header";
                }
            }
        }
        return $required_text;
    }

    protected function checkHeaderValue($headers = [])
    {
        foreach ($headers as $index => $header) {
            $header_value = request()->header($header);

            if ($header_value !== config('erp.credential.'.$header)) {
                return false;
            }
        }
       
        return true;
    }

    protected function checkEncryptValue($encrypt_values)
    {
        foreach ($encrypt_values as $key => $encrypt_value) {
            $header_value = request()->header($key);

            if ($encrypt_value !== $header_value) {
                return false;
            }
        }
       
        return true;
    }
}
