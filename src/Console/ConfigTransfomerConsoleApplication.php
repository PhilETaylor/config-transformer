<?php

declare (strict_types=1);
namespace ConfigTransformer202112023\Symplify\ConfigTransformer\Console;

use ConfigTransformer202112023\Symfony\Component\Console\Application;
use ConfigTransformer202112023\Symfony\Component\Console\Command\Command;
final class ConfigTransfomerConsoleApplication extends \ConfigTransformer202112023\Symfony\Component\Console\Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands)
    {
        parent::__construct('Config Transformer');
        $this->addCommands($commands);
    }
}
