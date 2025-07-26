<?php

namespace FabriceKabongo\LaravelHardened\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->secure()) {
            $secureUrl = 'https://' . $request->getHttpHost() . $request->getRequestUri();

            return redirect()->to($secureUrl, 301);
        }

        $response = $next($request);

        $maxAge = config('hardening.hsts_max_age', 31536000);
        $includeSub = config('hardening.include_sub_domains', true) ? '; includeSubDomains' : '';
        $response->headers->set('Strict-Transport-Security', "max-age={$maxAge}{$includeSub}");

        $csp = config('hardening.csp', []);
        if ($csp) {
            $parts = [];
            foreach ($csp as $key => $val) {
                $parts[] = $key.' '.implode(' ', (array) $val);
            }
            $response->headers->set('Content-Security-Policy', implode('; ', $parts));
        }

        return $response;
    }
}
