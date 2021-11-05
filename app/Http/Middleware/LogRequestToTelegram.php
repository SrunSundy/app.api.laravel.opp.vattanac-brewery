<?php

namespace App\Http\Middleware;

use App\Http\Traits\TelegramLogTrait;
use Closure;

class LogRequestToTelegram
{
    use TelegramLogTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('LOG_PAYMENT')) {
            info("=========== begin log payment =============");
            $this->logRequestTelegram();
            info("=========== end log payment =============");
        }

        return $next($request);
    }
}
