<?php

namespace Reinfi\DependencyInjection\Test\Unit\Config\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Reinfi\DependencyInjection\Config\Factory\ModuleConfigFactory;
use Reinfi\DependencyInjection\Config\ModuleConfig;

/**
 * @package Reinfi\DependencyInjection\Test\Unit\Config\Factory
 */
class ModuleConfigFactoryTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function itReturnsModuleConfig(): void
    {
        $factory = new ModuleConfigFactory();

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')
            ->willReturn([ ModuleConfig::CONFIG_KEY => [] ]);

        self::assertIsArray(
            $factory($container->reveal()),
            'Factory should return array'
        );
    }

    /**
     * @test
     */
    public function itReturnsModuleConfigData(): void
    {
        $factory = new ModuleConfigFactory();

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')
            ->willReturn([ ModuleConfig::CONFIG_KEY => [ 'extractor' => '' ] ]);

        $config = $factory($container->reveal());

        self::assertArrayHasKey(
            'extractor',
            $config,
            'Config should contain extractor key'
        );
    }

    /**
     * @test
     */
    public function itReturnsEmptyConfig(): void
    {
        $factory = new ModuleConfigFactory();

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')
            ->willReturn([]);

        $config = $factory($container->reveal());

        self::assertCount(
            0,
            $config,
            'Config should be empty'
        );
    }

    /**
     * @test
     */
    public function itThrowsExceptionIfModuleConfigIsNotArray(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $factory = new ModuleConfigFactory();

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')
            ->willReturn([ ModuleConfig::CONFIG_KEY => true ]);

        $factory($container->reveal());
    }
}
