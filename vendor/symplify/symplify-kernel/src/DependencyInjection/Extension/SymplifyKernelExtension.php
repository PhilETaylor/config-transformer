<?php

declare (strict_types=1);
namespace ConfigTransformer202107245\Symplify\SymplifyKernel\DependencyInjection\Extension;

use ConfigTransformer202107245\Symfony\Component\Config\FileLocator;
use ConfigTransformer202107245\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107245\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer202107245\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyKernelExtension extends \ConfigTransformer202107245\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function load($configs, $containerBuilder) : void
    {
        $phpFileLoader = new \ConfigTransformer202107245\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer202107245\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
