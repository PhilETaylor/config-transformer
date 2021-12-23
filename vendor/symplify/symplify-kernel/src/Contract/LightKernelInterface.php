<?php

declare (strict_types=1);
namespace ConfigTransformer202112237\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202112237\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202112237\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202112237\Psr\Container\ContainerInterface;
}
