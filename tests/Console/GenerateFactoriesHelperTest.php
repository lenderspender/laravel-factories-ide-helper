<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper\Tests\Console;

use Artisan;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use LenderSpender\LaravelFactoriesIdeHelper\Tests\TestCase;
use Mockery;

class GenerateFactoriesHelperTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Artisan::command('ide-helper:meta', function () {});
        config([
            'ide-helper.filename' => '_ide_helper',
            'ide-helper.meta_filename' => '.phpstorm.meta.php',
        ]);
    }

    public function test_factories_helper_stops_when_meta_file_is_not_there(): void
    {
        $this->artisan('ide-helper:generate:factories')
            ->expectsQuestion('Meta file is not generated. Do you want to run ide-helper:meta?', false)
            ->expectsOutput('Meta file is not generated. Please run ide-helper:meta first.');
    }

    public function test_factories_helper_creates_helper_and_meta(): void
    {
        $filesystem = Mockery::spy(Filesystem::class);
        $filesystemManager = $this->mockInstance(FilesystemManager::class);
        $filesystemManager->expects('createLocalDriver')->with(['root' => base_path()])->andReturn($filesystem);

        $filesystem->expects('get')
            ->with('.phpstorm.meta.php')
            ->andReturn(file_get_contents(__DIR__ . '/../stub_files/.phpstorm.meta.not_exisiting.php'));

        $this->artisan('ide-helper:generate:factories')
            ->expectsQuestion('Meta file is not generated. Do you want to run ide-helper:meta?', true);

        $filesystem->shouldHaveReceived('put')->twice()->withArgs(function ($filename, $contents) {
            if ($filename === '.phpstorm.meta.php') {
                self::assertStringContainsString('\factory(0)', $contents);

                return true;
            }

            if ($filename === '_ide_helper_factory.php') {
                self::assertStringContainsString('ModelStubFactoryBuilder', $contents);

                return true;
            }

            return false;
        });
    }

    private function mockInstance(string $class): Mockery\MockInterface
    {
        $instance = Mockery::mock($class);

        return $this->app->instance($class, $instance);
    }
}
