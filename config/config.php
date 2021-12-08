<?php

declare (strict_types=1);
namespace ConfigTransformer202112086;

use ConfigTransformer202112086\PhpParser\BuilderFactory;
use ConfigTransformer202112086\PhpParser\NodeFinder;
use ConfigTransformer202112086\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202112086\Symfony\Component\Yaml\Parser;
use ConfigTransformer202112086\Symplify\ConfigTransformer\Command\SwitchFormatCommand;
use ConfigTransformer202112086\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer202112086\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer202112086\Symplify\SmartFileSystem\FileSystemFilter;
use function ConfigTransformer202112086\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202112086\Symplify\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202112086\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer202112086\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202112086\Symplify\ConfigTransformer\Command\SwitchFormatCommand::class)]);
    $services->set(\ConfigTransformer202112086\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202112086\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202112086\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202112086\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer202112086\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\ConfigTransformer202112086\Symplify\PackageBuilder\Yaml\ParametersMerger::class);
};
