<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;

class FactoryMetaHelper
{
    private const OVERRIDE_REGEX = '/override\(\\\\factory\(0\), map\(([\s\S]*)\)\);/s';

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
    public function generate(Collection $factories, string $currentContent): string
    {
        $override = $this->viewFactory->make('laravel-factories-ide-helper::factory-meta', [
            'factories' => $factories,
        ]);

        if (preg_match(self::OVERRIDE_REGEX, $currentContent, $matches)) {
            return preg_replace(self::OVERRIDE_REGEX, $override, $currentContent);
        }

        return str_replace(PHP_EOL . '}', PHP_EOL . '    ' . $override . PHP_EOL . PHP_EOL . '}', $currentContent);
    }
}
