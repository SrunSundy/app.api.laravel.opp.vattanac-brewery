<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PhoneAuthMiddleware
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
        if (!request()->get('country_code')) {
            request()->merge([
                'country_code' => 'kh',
            ]);
        }

        $validated = $request->validate([
            'contact_number' => 'required|phone:' . request()->get('country_code'),
        ]);

        if (request()->get('contact_number')) {
            request()->merge([
                'contact_number' => phone(request()->get('contact_number'), request()->get('country_code'))
            ]);
        }

        return $next($request);
    }
}
