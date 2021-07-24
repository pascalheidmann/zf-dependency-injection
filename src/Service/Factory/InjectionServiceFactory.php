<?php

declare(strict_types=1);

namespace Reinfi\DependencyInjection\Service\Factory;

use Psr\Container\ContainerInterface;
use Reinfi\DependencyInjection\Config\ModuleConfig;
use Reinfi\DependencyInjection\Service\CacheService;
use Reinfi\DependencyInjection\Service\Extractor\ExtractorInterface;
use Reinfi\DependencyInjection\Service\InjectionService;
use Laminas\Config\Config;

/**
 * @package Reinfi\DependencyInjection\Service\Factory
 */
class InjectionServiceFactory
{
    public function __invoke(ContainerInterface $container): InjectionService
    {
        /** @var ExtractorInterface $extractor */
        $extractor = $container->get(ExtractorInterface::class);

        /** @var CacheService $cache */
        $cache = $container->get(CacheService::class);

        return new InjectionService($extractor, $cache);
    }
}
