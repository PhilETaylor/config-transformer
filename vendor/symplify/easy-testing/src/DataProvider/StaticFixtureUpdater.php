<?php

declare (strict_types=1);
namespace ConfigTransformer2021110310\Symplify\EasyTesting\DataProvider;

use ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @api
 */
final class StaticFixtureUpdater
{
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo|string $originalFileInfo
     */
    public static function updateFixtureContent($originalFileInfo, string $changedContent, \ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        $newOriginalContent = self::resolveNewFixtureContent($originalFileInfo, $changedContent);
        self::getSmartFileSystem()->dumpFile($fixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    public static function updateExpectedFixtureContent(string $newOriginalContent, \ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileInfo $expectedFixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        self::getSmartFileSystem()->dumpFile($expectedFixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    private static function getSmartFileSystem() : \ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileSystem();
    }
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo|string $originalFileInfo
     */
    private static function resolveNewFixtureContent($originalFileInfo, string $changedContent) : string
    {
        if ($originalFileInfo instanceof \ConfigTransformer2021110310\Symplify\SmartFileSystem\SmartFileInfo) {
            $originalContent = $originalFileInfo->getContents();
        } else {
            $originalContent = $originalFileInfo;
        }
        if ($originalContent === $changedContent) {
            return $originalContent;
        }
        return $originalContent . '-----' . \PHP_EOL . $changedContent;
    }
}
