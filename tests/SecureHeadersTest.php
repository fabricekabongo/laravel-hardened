<?php

namespace FabriceKabongo\LaravelHardened\Tests;

use Illuminate\Http\Request;
use FabriceKabongo\LaravelHardened\Middleware\SecureHeaders;

class SecureHeadersTest extends TestCase
{
    public function testHeadersAreSet()
    {
        $request = Request::create('https://example.com');
        $middleware = new SecureHeaders(['default-src' => "'self'"]);

        $response = $middleware->handle($request, function () {
            return response('ok');
        });

        $this->assertEquals('max-age=31536000; includeSubDomains', $response->headers->get('Strict-Transport-Security'));
        $this->assertEquals('nosniff', $response->headers->get('X-Content-Type-Options'));
        $this->assertEquals('DENY', $response->headers->get('X-Frame-Options'));
        $this->assertEquals('1; mode=block', $response->headers->get('X-XSS-Protection'));
        $this->assertEquals("default-src 'self'", $response->headers->get('Content-Security-Policy'));
    }
}
