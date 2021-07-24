<?php

declare(strict_types=1);

namespace Reinfi\DependencyInjection\Controller;

use Reinfi\DependencyInjection\Service\AutoWiring\ResolverService;
use Reinfi\DependencyInjection\Service\Extractor\ExtractorInterface;
use Reinfi\DependencyInjection\Traits\WarmupTrait;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Mvc\Console\Controller\AbstractConsoleController;

/**
 * @codeCoverageIgnore
 *
 * @package Reinfi\DependencyInjection\Controller
 */
class CacheWarmupController extends AbstractConsoleController
{
    use WarmupTrait;

    /**
     * @var array
     */
    private $serviceManagerConfig;

    /**
     * @var ExtractorInterface
     */
    private $extractor;

    /**
     * @var ResolverService
     */
    private $resolverService;

    /**
     * @var StorageInterface
     */
    private $cache;

    /**
     * @param array              $serviceManagerConfig
     * @param ExtractorInterface $extractor
     * @param ResolverService    $resolverService
     * @param StorageInterface   $cache
     */
    public function __construct(
        array $serviceManagerConfig,
        ExtractorInterface $extractor,
        ResolverService $resolverService,
        StorageInterface $cache
    ) {
        $this->serviceManagerConfig = $serviceManagerConfig;
        $this->extractor = $extractor;
        $this->cache = $cache;
        $this->resolverService = $resolverService;
    }

    public function indexAction(): void
    {
        $factoriesConfig = $this->serviceManagerConfig['factories'];

        $this->warmupConfig(
            $factoriesConfig,
            $this->extractor,
            $this->resolverService,
            $this->cache
        );

        $this->console->writeLine('Finished cache warmup');
    }
}
