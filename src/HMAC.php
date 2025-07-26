<?php

namespace FabriceKabongo\LaravelHardened;

use Illuminate\Support\Str;

class HMAC
{
    /**
     * Sign a payload with a secret key using the configured algorithm.
     */
    public static function sign(string $payload, string $secret, string $algo = 'sha256'): string
    {
        return hash_hmac($algo, $payload, $secret);
    }

    /**
     * Verify that a payload matches the provided signature.
     */
    public static function verify(string $payload, string $signature, string $secret, string $algo = 'sha256'): bool
    {
        $expected = static::sign($payload, $secret, $algo);

        return hash_equals($expected, $signature);
    }
}
