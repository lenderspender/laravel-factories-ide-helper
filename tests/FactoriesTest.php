<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper\Tests;

use LenderSpender\LaravelFactoriesIdeHelper\Factories;

class FactoriesTest extends TestCase
{
    public function test_can_get_all_factory_namespaces(): void
    {
        $factory = $this->app->make(Factories::class)->all()->first();

        self::assertNotNull($factory);
        self::assertEquals('LenderSpender\LaravelFactoriesIdeHelper\Tests\Stubs', $factory->namespace);
        self::assertEquals('ModelStub', $factory->class);
    }
}
