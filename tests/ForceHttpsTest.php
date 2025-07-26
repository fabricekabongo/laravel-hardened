<?php

namespace FabriceKabongo\LaravelHardened\Tests;

use Illuminate\Http\Request;
use FabriceKabongo\LaravelHardened\Middleware\ForceHttps;

class ForceHttpsTest extends TestCase
{
    public function testRedirectsToHttpsWhenNotSecure()
    {
        $request = Request::create('http://example.com/foo');
        $middleware = new ForceHttps();
        $response = $middleware->handle($request, function () {});
        $this->assertTrue($response->isRedirect('https://example.com/foo'));
    }

    public function testPassesThroughWhenSecure()
    {
        $request = Request::create('https://example.com/foo');
        $middleware = new ForceHttps();
        $response = $middleware->handle($request, function () {
            return response('ok');
        });
        $this->assertEquals('ok', $response->getContent());
        $this->assertEquals('max-age=31536000; includeSubDomains', $response->headers->get('Strict-Transport-Security'));
    }
}
