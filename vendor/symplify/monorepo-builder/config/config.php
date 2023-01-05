<?php

declare (strict_types=1);
namespace ConfigTransformer202301;

use ConfigTransformer202301\Symfony\Component\Console\Application;
use ConfigTransformer202301\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Config\MBConfig;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Console\MonorepoBuilderApplication;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ValueObject\Option;
use ConfigTransformer202301\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202301\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202301\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer202301\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer202301\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202301\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (MBConfig $mbConfig) : void {
    $parameters = $mbConfig->parameters();
    $parameters->set('env(GITHUB_TOKEN)', null);
    $parameters->set(Option::GITHUB_TOKEN, '%env(GITHUB_TOKEN)%');
    $mbConfig->packageDirectories([]);
    $mbConfig->packageDirectoriesExcludes([]);
    $mbConfig->dataToAppend([]);
    $mbConfig->dataToRemove([]);
    $parameters->set(Option::EXCLUDE_PACKAGE_VERSION_CONFLICTS, []);
    $parameters->set(Option::IS_STAGE_REQUIRED, \false);
    $parameters->set(Option::STAGES_TO_ALLOW_EXISTING_TAG, []);
    // for back compatibility, better switch to "main"
    $mbConfig->defaultBranch('master');
    $mbConfig->packageAliasFormat('<major>.<minor>-dev');
    $mbConfig->composerSectionOrder([ComposerJsonSection::NAME, ComposerJsonSection::TYPE, ComposerJsonSection::DESCRIPTION, ComposerJsonSection::KEYWORDS, ComposerJsonSection::HOMEPAGE, ComposerJsonSection::LICENSE, ComposerJsonSection::AUTHORS, ComposerJsonSection::BIN, ComposerJsonSection::REQUIRE, ComposerJsonSection::REQUIRE_DEV, ComposerJsonSection::AUTOLOAD, ComposerJsonSection::AUTOLOAD_DEV, ComposerJsonSection::REPOSITORIES, ComposerJsonSection::PROVIDE, ComposerJsonSection::CONFLICT, ComposerJsonSection::REPLACE, ComposerJsonSection::SCRIPTS, ComposerJsonSection::SCRIPTS_DESCRIPTIONS, ComposerJsonSection::SUGGEST, ComposerJsonSection::CONFIG, ComposerJsonSection::MINIMUM_STABILITY, ComposerJsonSection::PREFER_STABLE, ComposerJsonSection::EXTRA]);
    $services = $mbConfig->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\MonorepoBuilder\\', __DIR__ . '/../packages')->exclude([
        // register manually
        __DIR__ . '/../packages/Release/ReleaseWorker',
    ]);
    $services->load('Symplify\\MonorepoBuilder\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Config/MBConfig.php', __DIR__ . '/../src/Exception', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // for autowired commands
    $services->alias(Application::class, MonorepoBuilderApplication::class);
    $services->set(PrivatesCaller::class);
    $services->set(ParametersMerger::class);
    $services->set(SmartFileSystem::class);
    $services->set(PrivatesCaller::class);
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(SymfonyStyleFactory::class);
    $services->set(SymfonyStyle::class)->factory([service(SymfonyStyleFactory::class), 'create']);
};
