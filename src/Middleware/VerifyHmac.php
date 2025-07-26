<?php

namespace FabriceKabongo\LaravelHardened\Middleware;

use Closure;
use Illuminate\Http\Request;
use FabriceKabongo\LaravelHardened\HMAC;

class VerifyHmac
{
    protected string $secret;
    protected string $algo;

    public function __construct(string $secret, string $algo = 'sha256')
    {
        $this->secret = $secret;
        $this->algo = $algo;
    }

    public function handle(Request $request, Closure $next)
    {
        $signature = $request->header('X-Signature');

        if (!$signature || !HMAC::verify($request->getContent(), $signature, $this->secret, $this->algo)) {
            abort(401, 'Invalid signature');
        }

        return $next($request);
    }
}
