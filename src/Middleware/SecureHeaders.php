<?php

namespace FabriceKabongo\LaravelHardened\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    protected array $csp;

    public function __construct(array $csp = [])
    {
        $this->csp = $csp;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        if ($this->csp) {
            $response->headers->set('Content-Security-Policy', $this->buildCsp());
        }

        return $response;
    }

    protected function buildCsp(): string
    {
        $parts = [];
        foreach ($this->csp as $key => $val) {
            $parts[] = $key.' '.implode(' ', (array) $val);
        }
        return implode('; ', $parts);
    }
}
