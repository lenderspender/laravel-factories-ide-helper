<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper;

use Illuminate\Support\ServiceProvider;
use LenderSpender\LaravelFactoriesIdeHelper\Console\GenerateFactoriesHelper;

class LaravelFactoriesIdeHelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'laravel-factories-ide-helper');
    }

    public function register()
    {
        $this->commands([
            GenerateFactoriesHelper::class,
        ]);
    }
}
