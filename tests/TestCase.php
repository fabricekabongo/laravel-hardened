<?php

namespace FabriceKabongo\LaravelHardened\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [\FabriceKabongo\LaravelHardened\HardeningServiceProvider::class];
    }
}
