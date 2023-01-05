<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge;

use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ComposerJsonFactory;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Configuration\MergedPackagesCollector;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Contract\ComposerKeyMergerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\PathResolver\AutoloadPathNormalizer;
use ConfigTransformer202301\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\MonorepoBuilder\Tests\Merge\ComposerJsonMerger\ComposerJsonMergerTest
 */
final class ComposerJsonMerger
{
    /**
     * @var \Symplify\MonorepoBuilder\ComposerJsonManipulator\ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var \Symplify\MonorepoBuilder\Merge\Configuration\MergedPackagesCollector
     */
    private $mergedPackagesCollector;
    /**
     * @var \Symplify\MonorepoBuilder\Merge\PathResolver\AutoloadPathNormalizer
     */
    private $autoloadPathNormalizer;
    /**
     * @var ComposerKeyMergerInterface[]
     */
    private $composerKeyMergers;
    /**
     * @param ComposerKeyMergerInterface[] $composerKeyMergers
     */
    public function __construct(ComposerJsonFactory $composerJsonFactory, MergedPackagesCollector $mergedPackagesCollector, AutoloadPathNormalizer $autoloadPathNormalizer, array $composerKeyMergers)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->mergedPackagesCollector = $mergedPackagesCollector;
        $this->autoloadPathNormalizer = $autoloadPathNormalizer;
        $this->composerKeyMergers = $composerKeyMergers;
    }
    /**
     * @param SmartFileInfo[] $composerPackagesFileInfos
     */
    public function mergeFileInfos(array $composerPackagesFileInfos) : ComposerJson
    {
        $mainComposerJson = $this->composerJsonFactory->createFromArray([]);
        foreach ($composerPackagesFileInfos as $composerPackageFileInfo) {
            $packageComposerJson = $this->composerJsonFactory->createFromFileInfo($composerPackageFileInfo);
            $this->mergeJsonToRootWithPackageFileInfo($mainComposerJson, $packageComposerJson, $composerPackageFileInfo);
        }
        return $mainComposerJson;
    }
    public function mergeJsonToRoot(ComposerJson $mainComposerJson, ComposerJson $newComposerJson) : void
    {
        $name = $newComposerJson->getName();
        if ($name !== null) {
            $this->mergedPackagesCollector->addPackage($name);
        }
        foreach ($this->composerKeyMergers as $composerKeyMerger) {
            $composerKeyMerger->merge($mainComposerJson, $newComposerJson);
        }
    }
    private function mergeJsonToRootWithPackageFileInfo(ComposerJson $mainComposerJson, ComposerJson $newComposerJson, SmartFileInfo $packageFileInfo) : void
    {
        // prepare paths before autolaod merging
        $this->autoloadPathNormalizer->normalizeAutoloadPaths($newComposerJson, $packageFileInfo);
        $this->mergeJsonToRoot($mainComposerJson, $newComposerJson);
    }
}
