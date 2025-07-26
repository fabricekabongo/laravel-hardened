# Laravel Hardened

A Laravel package providing hardened security features such as HMAC signing and secure middleware.

## Installation

Require via Composer:

```bash
composer require fabricekabongo/laravel-hardened
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="FabriceKabongo\\LaravelHardened\\HardeningServiceProvider" --tag=config
```

## Usage

### HMAC Utilities

```php
use FabriceKabongo\LaravelHardened\HMAC;

$signature = HMAC::sign($payload, $secret);
$valid = HMAC::verify($payload, $signature, $secret);
```

### Middleware

Register middleware in your `Kernel` to force HTTPS and add secure headers.

```php
protected $middleware = [
    \FabriceKabongo\LaravelHardened\Middleware\ForceHttps::class,
    \FabriceKabongo\LaravelHardened\Middleware\SecureHeaders::class,
];
```

Default CSP and HSTS values can be adjusted in `config/hardening.php`.
