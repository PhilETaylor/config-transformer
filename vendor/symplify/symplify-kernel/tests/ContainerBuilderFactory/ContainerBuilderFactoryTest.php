<?php

declare (strict_types=1);
namespace ConfigTransformer202210\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer202210\PHPUnit\Framework\TestCase;
use ConfigTransformer202210\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer202210\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202210\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new ContainerBuilderFactory(new ParameterMergingLoaderFactory());
        $containerBuilder = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $containerBuilder->has(SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
