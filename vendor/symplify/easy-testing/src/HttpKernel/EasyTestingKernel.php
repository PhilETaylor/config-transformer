<?php

declare (strict_types=1);
namespace ConfigTransformer202108029\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202108029\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202108029\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202108029\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
