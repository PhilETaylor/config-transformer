<?php

declare (strict_types=1);
namespace ConfigTransformer202111287;

use ConfigTransformer202111287\PhpParser\BuilderFactory;
use ConfigTransformer202111287\PhpParser\NodeFinder;
use ConfigTransformer202111287\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202111287\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202111287\Symfony\Component\Yaml\Parser;
use ConfigTransformer202111287\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202111287\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202111287\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202111287\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer202111287\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202111287\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer202111287\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202111287\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202111287\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer202111287\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202111287\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202111287\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202111287\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer202111287\Symplify\Astral\NodeFinder\SimpleNodeFinder::class);
    $services->set(\ConfigTransformer202111287\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202111287\Symplify\Astral\NodeValue\NodeValueResolver::class);
    $services->set(\ConfigTransformer202111287\Symplify\Astral\Naming\SimpleNameResolver::class)->factory(\ConfigTransformer202111287\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::class . '::create');
    $services->set(\ConfigTransformer202111287\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202111287\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202111287\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202111287\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
