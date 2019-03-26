<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;

class FactoryHelper
{
    /** @var Factory */
    private $viewFactory;

    /** @var Application */
    private $application;

    public function __construct(Factory $viewFactory, Application $application)
    {
        $this->viewFactory = $viewFactory;
        $this->application = $application;
    }

    /**
     * @param Collection|FactoryType[] $factories
     *
     * @return string
     */
    public function generate(Collection $factories): string
    {
        return $this->viewFactory->make('laravel-factories-ide-helper::factory-helper', [
            'namespaces' => $factories->groupBy('namespace'),
            'version' => $this->application->version(),
        ])
            ->render();
    }
}
