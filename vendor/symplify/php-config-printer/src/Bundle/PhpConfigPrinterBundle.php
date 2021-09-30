<?php

declare (strict_types=1);
namespace ConfigTransformer202109300\Symplify\PhpConfigPrinter\Bundle;

use ConfigTransformer202109300\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202109300\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109300\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202109300\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use ConfigTransformer202109300\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension;
use ConfigTransformer202109300\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider;
/**
 * This class is dislocated in non-standard location, so it's not added by symfony/flex to bundles.php and cause app to
 * crash. See https://github.com/symplify/symplify/issues/1952#issuecomment-628765364
 */
final class PhpConfigPrinterBundle extends \ConfigTransformer202109300\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $this->registerDefaultImplementations($containerBuilder);
        $containerBuilder->addCompilerPass(new \ConfigTransformer202109300\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer202109300\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202109300\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension();
    }
    private function registerDefaultImplementations(\ConfigTransformer202109300\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // set default implementations, if none provided - for better developer experience out of the box
        if (!$containerBuilder->has(\ConfigTransformer202109300\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class)) {
            $containerBuilder->autowire(\ConfigTransformer202109300\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider::class)->setPublic(\true);
            $containerBuilder->setAlias(\ConfigTransformer202109300\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \ConfigTransformer202109300\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider::class);
        }
    }
}
