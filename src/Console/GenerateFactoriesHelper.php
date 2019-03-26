<?php

declare(strict_types=1);

namespace LenderSpender\LaravelFactoriesIdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Collection;
use LenderSpender\LaravelFactoriesIdeHelper\Factories;
use LenderSpender\LaravelFactoriesIdeHelper\FactoryHelper;
use LenderSpender\LaravelFactoriesIdeHelper\FactoryMetaHelper;
use LenderSpender\LaravelFactoriesIdeHelper\FactoryType;

class GenerateFactoriesHelper extends Command
{
    protected $signature = 'ide-helper:generate:factories';

    protected $description = 'Generate IDE helper file for Laravel factories';

    /** @var Factories */
    private $factories;

    /** @var Filesystem */
    private $filesystem;

    /** @var Repository */
    private $configRepository;

    /** @var FactoryHelper */
    private $factoryHelper;

    /** @var FactoryMetaHelper */
    private $factoryMetaHelper;

    public function __construct(
        Factories $factories,
        FilesystemManager $filesystemManager,
        Repository $configRepository,
        FactoryHelper $factoryHelper,
        FactoryMetaHelper $factoryMetaHelper
    ) {
        parent::__construct();

        $this->factories = $factories;
        $this->filesystem = $filesystemManager->createLocalDriver(['root' => base_path()]);
        $this->configRepository = $configRepository;
        $this->factoryHelper = $factoryHelper;
        $this->factoryMetaHelper = $factoryMetaHelper;
    }

    public function handle()
    {
        $factories = $this->factories->all();

        $this->addToMetaFile($factories);
        $this->createHelperFile($factories);
    }

    /**
     * @param Collection|FactoryType[] $factories
     */
    private function addToMetaFile(Collection $factories): void
    {
        $metaFileName = $this->configRepository->get('ide-helper.meta_filename');

        if (! $this->filesystem->exists($metaFileName)) {
            $generateMeta = $this->confirm('Meta file is not generated. Do you want to run ide-helper:meta?', true);

            if (! $generateMeta) {
                $this->error('Meta file is not generated. Please run ide-helper:meta first.');

                return;
            }

            $this->call('ide-helper:meta');
        }

        $currentContent = $this->filesystem->get($metaFileName);
        $newContent = $this->factoryMetaHelper->generate($factories, $currentContent);

        $this->filesystem->put($metaFileName, $newContent);

        $this->info('Meta override is successfully written to ' . $metaFileName);
    }

    /**
     * @param Collection|FactoryType[] $factories
     */
    private function createHelperFile(Collection $factories): void
    {
        $filename = $this->configRepository->get('ide-helper.filename') . '_factory.php';
        $content = $this->factoryHelper->generate($factories);

        if ($this->filesystem->put($filename, $content)) {
            $this->info('A new helper file was written to ' . $filename);

            return;
        }

        $this->error('The helper file could not be created at ' . $filename);
    }
}
