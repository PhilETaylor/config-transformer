<?php

declare (strict_types=1);
namespace ConfigTransformer202206010\Symplify\EasyTesting;

use ConfigTransformer202206010\Nette\Utils\Strings;
use ConfigTransformer202206010\Symplify\EasyTesting\ValueObject\IncorrectAndMissingSkips;
use ConfigTransformer202206010\Symplify\EasyTesting\ValueObject\Prefix;
use ConfigTransformer202206010\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer202206010\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyTesting\Tests\MissingSkipPrefixResolver\MissingSkipPrefixResolverTest
 */
final class MissplacedSkipPrefixResolver
{
    /**
     * @param SmartFileInfo[] $fixtureFileInfos
     */
    public function resolve(array $fixtureFileInfos) : \ConfigTransformer202206010\Symplify\EasyTesting\ValueObject\IncorrectAndMissingSkips
    {
        $incorrectSkips = [];
        $missingSkips = [];
        foreach ($fixtureFileInfos as $fixtureFileInfo) {
            $hasNameSkipStart = $this->hasNameSkipStart($fixtureFileInfo);
            $fileContents = $fixtureFileInfo->getContents();
            $hasSplitLine = (bool) \ConfigTransformer202206010\Nette\Utils\Strings::match($fileContents, \ConfigTransformer202206010\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
            if ($hasNameSkipStart && $hasSplitLine) {
                $incorrectSkips[] = $fixtureFileInfo;
                continue;
            }
            if (!$hasNameSkipStart && !$hasSplitLine) {
                $missingSkips[] = $fixtureFileInfo;
            }
        }
        return new \ConfigTransformer202206010\Symplify\EasyTesting\ValueObject\IncorrectAndMissingSkips($incorrectSkips, $missingSkips);
    }
    private function hasNameSkipStart(\ConfigTransformer202206010\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : bool
    {
        return (bool) \ConfigTransformer202206010\Nette\Utils\Strings::match($fixtureFileInfo->getBasenameWithoutSuffix(), \ConfigTransformer202206010\Symplify\EasyTesting\ValueObject\Prefix::SKIP_PREFIX_REGEX);
    }
}
