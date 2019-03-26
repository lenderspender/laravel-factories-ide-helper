<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Collection;
use ReflectionClass;

class Factories
{
    /** @var EloquentFactory */
    private $factory;

    public function __construct(EloquentFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return Collection|FactoryType[]
     */
    public function all(): Collection
    {
        $definitions = (new ReflectionClass(EloquentFactory::class))->getProperty('definitions');
        $definitions->setAccessible(true);

        return collect($definitions->getValue($this->factory))
            ->keys()
            ->map(function ($factoryTarget) {
                $reflectionClass = new ReflectionClass($factoryTarget);

                return new FactoryType($reflectionClass->getNamespaceName(), $reflectionClass->getShortName());
            });
    }
}
