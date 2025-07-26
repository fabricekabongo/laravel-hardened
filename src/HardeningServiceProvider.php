<?php

namespace FabriceKabongo\LaravelHardened;

use Illuminate\Support\ServiceProvider;

class HardeningServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/hardening.php' => config_path('hardening.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/hardening.php', 'hardening');
    }
}
