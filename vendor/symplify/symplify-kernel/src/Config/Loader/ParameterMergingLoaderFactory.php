<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\SymplifyKernel\Config\Loader;

use ConfigTransformer202301\Symfony\Component\Config\FileLocator;
use ConfigTransformer202301\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer202301\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformer202301\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer202301\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202301\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
use ConfigTransformer202301\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
final class ParameterMergingLoaderFactory implements LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202301\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new FileLocator([$currentWorkingDirectory]);
        $loaders = [new GlobFileLoader($fileLocator), new ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new LoaderResolver($loaders);
        return new DelegatingLoader($loaderResolver);
    }
}
