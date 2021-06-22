<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer2021062210\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021062210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer2021062210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer2021062210\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
