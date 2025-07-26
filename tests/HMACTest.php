<?php

namespace FabriceKabongo\LaravelHardened\Tests;

use FabriceKabongo\LaravelHardened\HMAC;

class HMACTest extends TestCase
{
    public function testSignAndVerify()
    {
        $payload = 'example';
        $secret = 'mysecret';

        $sig = HMAC::sign($payload, $secret);

        $this->assertTrue(HMAC::verify($payload, $sig, $secret));
        $this->assertFalse(HMAC::verify($payload, 'invalid', $secret));
    }
}
