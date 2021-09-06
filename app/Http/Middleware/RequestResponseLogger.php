<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestResponseLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        if (config('app.debug')) {
            $log = '******* ';
            $log .= $_SERVER['REQUEST_METHOD'];
            $log .= " ";
            $log .= $_SERVER['REQUEST_URI'];
            $log .= " ";
            $log .= (microtime(true) - LARAVEL_START) * 100 . "ms";
            $log .= " ";
            $log .= $_SERVER['HTTP_USER_AGENT'];
            $log .= ' (Authorization:  ';
            $log .= $request->header('Authorization') . ' ) ';
            $log .= ' (device:  ';
            $log .= $request->header('Device-Type') . ' ) ';
            if (strpos($log, 'api') > 0) {
                $action = " app-request-start \n";
                $data = [
                    'request' => $request->all(),
                ];
                if ($response->getStatusCode() <> 200) {
                    $data['response'] = $response;
                }
                Log::info($log . ' ' . $response->getStatusCode() . '' . $action, $data);
            }
        }
    }
}
