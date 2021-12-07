<?php

declare (strict_types=1);
namespace ConfigTransformer202112073\Symplify\EasyTesting\FixtureSplitter;

use ConfigTransformer202112073\Nette\Utils\Strings;
use ConfigTransformer202112073\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent;
use ConfigTransformer202112073\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer202112073\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202112073\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @api
 */
final class TrioFixtureSplitter
{
    public function splitFileInfo(\ConfigTransformer202112073\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \ConfigTransformer202112073\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent
    {
        $parts = \ConfigTransformer202112073\Nette\Utils\Strings::split($smartFileInfo->getContents(), \ConfigTransformer202112073\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
        $this->ensureHasThreeParts($parts, $smartFileInfo);
        return new \ConfigTransformer202112073\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent($parts[0], $parts[1], $parts[2]);
    }
    /**
     * @param mixed[] $parts
     */
    private function ensureHasThreeParts(array $parts, \ConfigTransformer202112073\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if (\count($parts) === 3) {
            return;
        }
        $message = \sprintf('The fixture "%s" should have 3 parts. %d found', $smartFileInfo->getRelativeFilePathFromCwd(), \count($parts));
        throw new \ConfigTransformer202112073\Symplify\SymplifyKernel\Exception\ShouldNotHappenException($message);
    }
}
