<?php

declare(strict_types=1);

namespace Reinfi\DependencyInjection\Annotation;

/**
 * @package Reinfi\DependencyInjection\Annotation
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
final class InjectViewHelper extends AbstractInjectPluginManager
{
    /**
     * @var string
     */
    const PLUGIN_MANAGER = 'ViewHelperManager';
}
