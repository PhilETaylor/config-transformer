<?php

declare (strict_types=1);
namespace ConfigTransformer202110311\Symplify\PackageBuilder\Console\Command;

use ConfigTransformer202110311\Symfony\Component\Console\Command\Command;
use ConfigTransformer202110311\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer202110311\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202110311\Symfony\Contracts\Service\Attribute\Required;
use ConfigTransformer202110311\Symplify\PackageBuilder\ValueObject\Option;
use ConfigTransformer202110311\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer202110311\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer202110311\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \ConfigTransformer202110311\Symfony\Component\Console\Command\Command
{
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    protected $symfonyStyle;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    protected $smartFileSystem;
    /**
     * @var \Symplify\SmartFileSystem\Finder\SmartFinder
     */
    protected $smartFinder;
    /**
     * @var \Symplify\SmartFileSystem\FileSystemGuard
     */
    protected $fileSystemGuard;
    public function __construct()
    {
        parent::__construct();
        $this->addOption(\ConfigTransformer202110311\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \ConfigTransformer202110311\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    /**
     * @required
     */
    public function autowireAbstractSymplifyCommand(\ConfigTransformer202110311\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer202110311\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer202110311\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \ConfigTransformer202110311\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
