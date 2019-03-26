<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper\Tests;

use LenderSpender\LaravelFactoriesIdeHelper\LaravelFactoriesIdeHelperServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/factories');
    }

    protected function getPackageProviders($app)
    {
        return [LaravelFactoriesIdeHelperServiceProvider::class];
    }
}
