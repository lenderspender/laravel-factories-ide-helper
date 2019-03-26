<?php

declare(strict_types=1);

/* @var \Illuminate\Database\Eloquent\Factory $factory */

use LenderSpender\LaravelFactoriesIdeHelper\Tests\Stubs\ModelStub;

$factory->define(ModelStub::class, function () {
    return [
        'foo' => 'bar',
    ];
});
