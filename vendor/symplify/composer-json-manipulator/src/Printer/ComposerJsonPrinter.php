<?php

declare (strict_types=1);
namespace ConfigTransformer2021110310\Symplify\ComposerJsonManipulator\Printer;

use ConfigTransformer2021110310\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use ConfigTransformer2021110310\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @api
 */
final class ComposerJsonPrinter
{
    /**
     * @var \Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\ConfigTransformer2021110310\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\ConfigTransformer2021110310\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo|string $targetFile
     */
    public function print(\ConfigTransformer2021110310\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
