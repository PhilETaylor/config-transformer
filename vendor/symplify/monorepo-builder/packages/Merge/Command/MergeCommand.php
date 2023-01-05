<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Command;

use ConfigTransformer202301\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202301\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ComposerJsonFactory;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\FileSystem\JsonFileManager;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202301\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Application\MergedAndDecoratedComposerJsonFactory;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Guard\ConflictingVersionsGuard;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator;
use ConfigTransformer202301\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
final class MergeCommand extends AbstractSymplifyCommand
{
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\ComposerJsonManipulator\ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var \Symplify\MonorepoBuilder\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    /**
     * @var \Symplify\MonorepoBuilder\Merge\Application\MergedAndDecoratedComposerJsonFactory
     */
    private $mergedAndDecoratedComposerJsonFactory;
    /**
     * @var \Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator
     */
    private $sourcesPresenceValidator;
    /**
     * @var \Symplify\MonorepoBuilder\Merge\Guard\ConflictingVersionsGuard
     */
    private $conflictingVersionsGuard;
    public function __construct(ComposerJsonProvider $composerJsonProvider, ComposerJsonFactory $composerJsonFactory, JsonFileManager $jsonFileManager, MergedAndDecoratedComposerJsonFactory $mergedAndDecoratedComposerJsonFactory, SourcesPresenceValidator $sourcesPresenceValidator, ConflictingVersionsGuard $conflictingVersionsGuard)
    {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->composerJsonFactory = $composerJsonFactory;
        $this->jsonFileManager = $jsonFileManager;
        $this->mergedAndDecoratedComposerJsonFactory = $mergedAndDecoratedComposerJsonFactory;
        $this->sourcesPresenceValidator = $sourcesPresenceValidator;
        $this->conflictingVersionsGuard = $conflictingVersionsGuard;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('merge');
        $this->setDescription('Merge "composer.json" from all found packages to root one');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $this->sourcesPresenceValidator->validatePackageComposerJsons();
        $this->conflictingVersionsGuard->ensureNoConflictingPackageVersions();
        $rootComposerJsonFilePath = \getcwd() . '/composer.json';
        $rootComposerJson = $this->getRootComposerJson($rootComposerJsonFilePath);
        $packageFileInfos = $this->composerJsonProvider->getPackagesComposerFileInfos();
        $this->mergedAndDecoratedComposerJsonFactory->createFromRootConfigAndPackageFileInfos($rootComposerJson, $packageFileInfos);
        $this->jsonFileManager->printComposerJsonToFilePath($rootComposerJson, $rootComposerJsonFilePath);
        $this->symfonyStyle->success('Root "composer.json" was updated.');
        return self::SUCCESS;
    }
    private function getRootComposerJson(string $rootComposerJsonFilePath) : ComposerJson
    {
        $rootComposerJson = $this->composerJsonFactory->createFromFilePath($rootComposerJsonFilePath);
        // ignore "provide" section in current root composer.json
        $rootComposerJson->setProvide([]);
        return $rootComposerJson;
    }
}
