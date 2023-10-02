<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310\Symplify\SymplifyKernel\Config\Loader;

use ConfigTransformerPrefix202310\Symfony\Component\Config\FileLocator;
use ConfigTransformerPrefix202310\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformerPrefix202310\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformerPrefix202310\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
use ConfigTransformerPrefix202310\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
final class ParameterMergingLoaderFactory implements LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformerPrefix202310\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new FileLocator([$currentWorkingDirectory]);
        $loaders = [new GlobFileLoader($fileLocator), new ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new LoaderResolver($loaders);
        return new DelegatingLoader($loaderResolver);
    }
}
