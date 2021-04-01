<?php

namespace Reinfi\DependencyInjection\Test\Unit\Service\Extractor;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Reinfi\DependencyInjection\Annotation\AnnotationInterface;
use Reinfi\DependencyInjection\Exception\InjectionTypeUnknownException;
use Reinfi\DependencyInjection\Service\Extractor\YamlExtractor;
use Reinfi\DependencyInjection\Test\Service\Service1;
use Reinfi\DependencyInjection\Test\Service\Service2;
use Reinfi\DependencyInjection\Test\Service\ServiceAnnotation;
use Symfony\Component\Yaml\Yaml;

/**
 * @package Reinfi\DependencyInjection\Test\Test\Unit\Service\Extractor
 */
class YamlExtractorTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnEmptyArrayForPropertyInjections()
    {
        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/services.yml',
            'Reinfi\DependencyInjection\Annotation'
        );

        $injections = $extractor->getPropertiesInjections(Service1::class);

        $this->assertCount(0, $injections);
    }

    /**
     * @test
     */
    public function itShouldReturnInjections()
    {
        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/services.yml',
            'Reinfi\DependencyInjection\Annotation'
        );

        $injections = $extractor->getConstructorInjections(Service1::class);

        $this->assertContainsOnlyInstancesOf(AnnotationInterface::class, $injections);
    }

    /**
     * @test
     */
    public function itShouldSetRequiredInjectionProperties()
    {
        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/services.yml',
            'Reinfi\DependencyInjection\Annotation'
        );

        $injections = $extractor->getConstructorInjections(Service1::class);

        $this->assertEquals(
            Service2::class,
            $injections[0]->value,
            'First injection should be of type ' . Service2::class
        );
    }

    /**
     * @test
     */
    public function itShouldReturnInjectionsIfTypeHasContructorArguments()
    {
        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/services.yml',
            'Reinfi\DependencyInjection\Annotation'
        );

        $injections = $extractor->getConstructorInjections('Reinfi\DependencyInjection\Service\ServiceDoctrine');

        $this->assertContainsOnlyInstancesOf(AnnotationInterface::class, $injections);
    }

    /**
     * @test
     */
    public function itShouldReturnNoInjectionsIfNotDefined()
    {
        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/services.yml',
            'Reinfi\DependencyInjection\Annotation'
        );

        $injections = $extractor->getConstructorInjections(Service2::class);

        $this->assertCount(0, $injections);
    }

    /**
     * @test
     */
    public function itThrowsExceptionIfConfigurationKeyTypeMisses()
    {
        $this->expectException(InvalidArgumentException::class);

        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/bad_services.yml',
            'Reinfi\DependencyInjection\Annotation'
        );

        $extractor->getConstructorInjections(Service1::class);
    }

    /**
     * @test
     */
    public function itThrowsExceptionIfTypeIsUnknown()
    {
        $this->expectException(InjectionTypeUnknownException::class);

        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/bad_services.yml',
            'Reinfi\DependencyInjection\Annotation'
        );

        $extractor->getConstructorInjections(Service2::class);
    }

    /**
     * @test
     */
    public function itThrowsExceptionIfTypeIsNotOfTypeInjectionInterface()
    {
        $this->expectException(InjectionTypeUnknownException::class);

        $extractor = new YamlExtractor(
            new Yaml(),
            __DIR__ . '/../../../resources/bad_services.yml',
            'Reinfi\DependencyInjection\Test\Service'
        );

        $extractor->getConstructorInjections(ServiceAnnotation::class);
    }
}
