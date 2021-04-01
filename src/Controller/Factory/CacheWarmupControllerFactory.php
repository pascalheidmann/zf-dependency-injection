<?php

declare(strict_types=1);

namespace Reinfi\DependencyInjection\Controller\Factory;

use Psr\Container\ContainerInterface;
use Reinfi\DependencyInjection\Controller\CacheWarmupController;
use Reinfi\DependencyInjection\Service\AutoWiring\ResolverService;
use Reinfi\DependencyInjection\Service\CacheService;
use Reinfi\DependencyInjection\Service\Extractor\ExtractorInterface;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * @codeCoverageIgnore
 *
 * @package Reinfi\DependencyInjection\Controller\Factory
 */
class CacheWarmupControllerFactory
{
    public function __invoke(ContainerInterface $container): CacheWarmupController
    {
        if ($container instanceof AbstractPluginManager) {
            $container = $container->getServiceLocator();
        }

        $serviceManagerConfig = $container->get('config')['service_manager'];

        /** @var ExtractorInterface $extractor */
        $extractor = $container->get(ExtractorInterface::class);

        /** @var ResolverService $resolverService */
        $resolverService = $container->get(ResolverService::class);

        /** @var CacheService $cache */
        $cache = $container->get(CacheService::class);

        return new CacheWarmupController(
            $serviceManagerConfig,
            $extractor,
            $resolverService,
            $cache
        );
    }
}
