<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Git;

use ConfigTransformer202301\Symfony\Component\Process\Process;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Utils\VersionUtils;
final class ExpectedAliasResolver
{
    /**
     * @var \Symplify\MonorepoBuilder\Utils\VersionUtils
     */
    private $versionUtils;
    public function __construct(VersionUtils $versionUtils)
    {
        $this->versionUtils = $versionUtils;
    }
    public function resolve() : string
    {
        $process = new Process(['git', 'describe', '--abbrev=0', '--tags']);
        $process->run();
        $output = $process->getOutput();
        return $this->versionUtils->getNextAliasFormat($output);
    }
}
