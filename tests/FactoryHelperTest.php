<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper\Tests;

use Carbon\Carbon;
use LenderSpender\LaravelFactoriesIdeHelper\FactoryHelper;
use LenderSpender\LaravelFactoriesIdeHelper\FactoryType;

class FactoryHelperTest extends TestCase
{
    public function test_generate_adds_new_override_method(): void
    {
        Carbon::setTestNow('2019-03-26 10:01:02');
        $application = $this->partialMock(\Illuminate\Contracts\Foundation\Application::class);
        $application->expects('version')->andReturn('5.8.8');

        $factoryHelper = $this->app->make(FactoryHelper::class);
        $factories = collect([new FactoryType('App\\Model', 'User')]);

        $contents = $factoryHelper->generate($factories);

        self::assertEquals(file_get_contents(__DIR__ . '/stub_files/_ide_helper_factories.php'), $contents);
    }
}
