<?php

declare (strict_types=1);
namespace ConfigTransformer202201173;

use ConfigTransformer202201173\PhpParser\ConstExprEvaluator;
use ConfigTransformer202201173\PhpParser\NodeFinder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202201173\Symplify\Astral\PhpParser\SmartPhpParser;
use ConfigTransformer202201173\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use ConfigTransformer202201173\Symplify\PackageBuilder\Php\TypeChecker;
use function ConfigTransformer202201173\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer202201173\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php']);
    $services->set(\ConfigTransformer202201173\Symplify\Astral\PhpParser\SmartPhpParser::class)->factory([\ConfigTransformer202201173\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202201173\Symplify\Astral\PhpParser\SmartPhpParserFactory::class), 'create']);
    $services->set(\ConfigTransformer202201173\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer202201173\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202201173\PhpParser\NodeFinder::class);
};
