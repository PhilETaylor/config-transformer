<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210;

use ConfigTransformer2021062210\PhpParser\ConstExprEvaluator;
use ConfigTransformer2021062210\PhpParser\NodeFinder;
use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021062210\Symplify\PackageBuilder\Php\TypeChecker;
return static function (\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer2021062210\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer2021062210\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer2021062210\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2021062210\PhpParser\NodeFinder::class);
};
