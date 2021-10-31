<?php

declare (strict_types=1);
namespace ConfigTransformer202110311\Symplify\SmartFileSystem\Finder;

use ConfigTransformer202110311\Nette\Utils\Finder as NetteFinder;
use SplFileInfo;
use ConfigTransformer202110311\Symfony\Component\Finder\Finder as SymfonyFinder;
use ConfigTransformer202110311\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use ConfigTransformer202110311\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer\FinderSanitizerTest
 */
final class FinderSanitizer
{
    /**
     * @param mixed[]|\Nette\Utils\Finder|\Symfony\Component\Finder\Finder $files
     * @return SmartFileInfo[]
     */
    public function sanitize($files) : array
    {
        $smartFileInfos = [];
        foreach ($files as $file) {
            $fileInfo = \is_string($file) ? new \SplFileInfo($file) : $file;
            if (!$this->isFileInfoValid($fileInfo)) {
                continue;
            }
            /** @var string $realPath */
            $realPath = $fileInfo->getRealPath();
            $smartFileInfos[] = new \ConfigTransformer202110311\Symplify\SmartFileSystem\SmartFileInfo($realPath);
        }
        return $smartFileInfos;
    }
    private function isFileInfoValid(\SplFileInfo $fileInfo) : bool
    {
        return (bool) $fileInfo->getRealPath();
    }
}
