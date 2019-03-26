<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper;

class FactoryType
{
    /** @var string */
    public $namespace;

    /** @var string */
    public $class;

    public function __construct(string $namespace, string $class)
    {
        $this->namespace = $namespace;
        $this->class = $class;
    }
}
