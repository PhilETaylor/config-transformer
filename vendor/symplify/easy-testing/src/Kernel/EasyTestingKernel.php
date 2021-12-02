<?php

declare (strict_types=1);
namespace ConfigTransformer202112023\Symplify\EasyTesting\Kernel;

use ConfigTransformer202112023\Psr\Container\ContainerInterface;
use ConfigTransformer202112023\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer202112023\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202112023\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202112023\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer202112023\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create([], [], $configFiles);
    }
}
