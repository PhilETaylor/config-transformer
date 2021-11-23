<?php

declare (strict_types=1);
namespace ConfigTransformer202111231\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202111231\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111231\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202111231\Psr\Container\ContainerInterface;
}
