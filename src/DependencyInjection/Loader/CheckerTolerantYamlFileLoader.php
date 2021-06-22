<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\ConfigTransformer\DependencyInjection\Loader;

use ConfigTransformer2021062210\Symfony\Component\Config\FileLocatorInterface;
use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter;
/**
 * @see https://github.com/symplify/config-transformer/commit/0244abf3953eb0c5578d203b75749545f705c2a3
 */
final class CheckerTolerantYamlFileLoader extends \ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Loader\YamlFileLoader
{
    /**
     * @var \Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter
     */
    private $checkerServiceParametersShifter;
    public function __construct(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \ConfigTransformer2021062210\Symfony\Component\Config\FileLocatorInterface $fileLocator)
    {
        $this->checkerServiceParametersShifter = new \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter();
        parent::__construct($containerBuilder, $fileLocator);
    }
    /**
     * @param string $file
     * @return mixed[]
     */
    protected function loadFile($file) : array
    {
        /** @var mixed[]|null $configuration */
        $configuration = parent::loadFile($file);
        if ($configuration === null) {
            return [];
        }
        return $this->checkerServiceParametersShifter->process($configuration);
    }
}
