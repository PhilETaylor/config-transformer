<?php

declare (strict_types=1);
namespace ConfigTransformer202106196\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202106196\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202106196\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202106196\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202106196\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
