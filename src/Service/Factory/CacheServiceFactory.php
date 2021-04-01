<?php

declare(strict_types=1);

namespace Reinfi\DependencyInjection\Service\Factory;

use Psr\Container\ContainerInterface;
use Reinfi\DependencyInjection\Config\ModuleConfig;
use Reinfi\DependencyInjection\Service\CacheService;
use Laminas\Cache\Storage\Adapter\Memory;
use Laminas\Cache\StorageFactory;

/**
 * @package Reinfi\DependencyInjection\Service\Factory
 */
class CacheServiceFactory
{
    public function __invoke(ContainerInterface $container): CacheService
    {
        /** @var array $config */
        $config = $container->get(ModuleConfig::class);

        $cacheAdapter = $config['cache'] ?? Memory::class;

        $cacheOptions = $config['cache_options'] ?? [];

        $cachePlugins = $config['cache_plugins'] ?? [];

        $cache = StorageFactory::factory(
            [
                'adapter' => [
                    'name'    => $cacheAdapter,
                    'options' => $cacheOptions,
                ],
                'plugins' => $cachePlugins,
            ]
        );

        return new CacheService($cache);
    }
}
