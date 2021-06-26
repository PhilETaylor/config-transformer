<?php

declare (strict_types=1);
namespace ConfigTransformer202106265\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202106265\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202106265\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202106265\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202106265\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
