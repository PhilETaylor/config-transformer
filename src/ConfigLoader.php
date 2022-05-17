<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\ConfigTransformer;

use ConfigTransformer2022051710\Nette\Utils\Strings;
use ConfigTransformer2022051710\Symfony\Component\Config\FileLocator;
use ConfigTransformer2022051710\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer2022051710\Symfony\Component\Config\Loader\Loader;
use ConfigTransformer2022051710\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer2022051710\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use ConfigTransformer2022051710\Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker;
use ConfigTransformer2022051710\Symplify\ConfigTransformer\DependencyInjection\Loader\CheckerTolerantYamlFileLoader;
use ConfigTransformer2022051710\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory;
use ConfigTransformer2022051710\Symplify\ConfigTransformer\Enum\Format;
use ConfigTransformer2022051710\Symplify\ConfigTransformer\Exception\NotImplementedYetException;
use ConfigTransformer2022051710\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent;
use ConfigTransformer2022051710\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2022051710\Symplify\SmartFileSystem\SmartFileSystem;
final class ConfigLoader
{
    /**
     * @see https://regex101.com/r/Mnd9vH/1
     * @var string
     */
    private const PHP_CONST_REGEX = '#\\!php\\/const\\:( )?#';
    /**
     * @var \Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory
     */
    private $idAwareXmlFileLoaderFactory;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var \Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker
     */
    private $extensionFaker;
    public function __construct(\ConfigTransformer2022051710\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory $idAwareXmlFileLoaderFactory, \ConfigTransformer2022051710\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer2022051710\Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker $extensionFaker)
    {
        $this->idAwareXmlFileLoaderFactory = $idAwareXmlFileLoaderFactory;
        $this->smartFileSystem = $smartFileSystem;
        $this->extensionFaker = $extensionFaker;
    }
    public function createAndLoadContainerBuilderFromFileInfo(\ConfigTransformer2022051710\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \ConfigTransformer2022051710\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent
    {
        $containerBuilder = new \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\ContainerBuilder();
        $delegatingLoader = $this->createLoaderBySuffix($containerBuilder, $smartFileInfo->getSuffix());
        $fileRealPath = $smartFileInfo->getRealPath();
        // correct old syntax of tags so we can parse it
        $content = $smartFileInfo->getContents();
        if (\in_array($smartFileInfo->getSuffix(), [\ConfigTransformer2022051710\Symplify\ConfigTransformer\Enum\Format::YML, \ConfigTransformer2022051710\Symplify\ConfigTransformer\Enum\Format::YAML], \true)) {
            $content = \ConfigTransformer2022051710\Nette\Utils\Strings::replace($content, self::PHP_CONST_REGEX, '!php/const ');
            if ($content !== $smartFileInfo->getContents()) {
                $fileRealPath = \sys_get_temp_dir() . '/_migrify_config_tranformer_clean_yaml/' . $smartFileInfo->getFilename();
                $this->smartFileSystem->dumpFile($fileRealPath, $content);
            }
            $this->extensionFaker->fakeInContainerBuilder($containerBuilder, $content);
        }
        $delegatingLoader->load($fileRealPath);
        return new \ConfigTransformer2022051710\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent($containerBuilder, $content);
    }
    private function createLoaderBySuffix(\ConfigTransformer2022051710\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $suffix) : \ConfigTransformer2022051710\Symfony\Component\Config\Loader\DelegatingLoader
    {
        if ($suffix === \ConfigTransformer2022051710\Symplify\ConfigTransformer\Enum\Format::XML) {
            $idAwareXmlFileLoader = $this->idAwareXmlFileLoaderFactory->createFromContainerBuilder($containerBuilder);
            return $this->wrapToDelegatingLoader($idAwareXmlFileLoader, $containerBuilder);
        }
        if (\in_array($suffix, [\ConfigTransformer2022051710\Symplify\ConfigTransformer\Enum\Format::YML, \ConfigTransformer2022051710\Symplify\ConfigTransformer\Enum\Format::YAML], \true)) {
            $yamlFileLoader = new \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, new \ConfigTransformer2022051710\Symfony\Component\Config\FileLocator());
            return $this->wrapToDelegatingLoader($yamlFileLoader, $containerBuilder);
        }
        if ($suffix === \ConfigTransformer2022051710\Symplify\ConfigTransformer\Enum\Format::PHP) {
            $phpFileLoader = new \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer2022051710\Symfony\Component\Config\FileLocator());
            return $this->wrapToDelegatingLoader($phpFileLoader, $containerBuilder);
        }
        throw new \ConfigTransformer2022051710\Symplify\ConfigTransformer\Exception\NotImplementedYetException($suffix);
    }
    private function wrapToDelegatingLoader(\ConfigTransformer2022051710\Symfony\Component\Config\Loader\Loader $loader, \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer2022051710\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $globFileLoader = new \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Loader\GlobFileLoader($containerBuilder, new \ConfigTransformer2022051710\Symfony\Component\Config\FileLocator());
        $phpFileLoader = new \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer2022051710\Symfony\Component\Config\FileLocator());
        $checkerTolerantYamlFileLoader = new \ConfigTransformer2022051710\Symplify\ConfigTransformer\DependencyInjection\Loader\CheckerTolerantYamlFileLoader($containerBuilder, new \ConfigTransformer2022051710\Symfony\Component\Config\FileLocator());
        return new \ConfigTransformer2022051710\Symfony\Component\Config\Loader\DelegatingLoader(new \ConfigTransformer2022051710\Symfony\Component\Config\Loader\LoaderResolver([$globFileLoader, $phpFileLoader, $checkerTolerantYamlFileLoader, $loader]));
    }
}
