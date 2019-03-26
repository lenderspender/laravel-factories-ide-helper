<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper\Tests;

use LenderSpender\LaravelFactoriesIdeHelper\FactoryMetaHelper;
use LenderSpender\LaravelFactoriesIdeHelper\FactoryType;

class FactoryHelperTest extends TestCase
{
    public function test_generate_adds_new_override_method(): void
    {
        $factoryMetaHelper = $this->app->make(FactoryMetaHelper::class);
        $factories = collect([new FactoryType('App\\Model', 'User')]);

        $contents = $factoryMetaHelper->generate($factories, file_get_contents(__DIR__ . '/stub_files/.phpstorm.meta.not_exisiting.php'));

        self::assertEquals(file_get_contents(__DIR__ . '/stub_files/.phpstorm.meta.existing.php'), $contents);
    }
}
