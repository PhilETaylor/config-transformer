<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202201177\Symfony\Component\Console\Event;

use ConfigTransformer202201177\Symfony\Component\Console\Command\Command;
use ConfigTransformer202201177\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202201177\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202201177\Symfony\Contracts\EventDispatcher\Event;
/**
 * Allows to inspect input and output of a command.
 *
 * @author Francesco Levorato <git@flevour.net>
 */
class ConsoleEvent extends \ConfigTransformer202201177\Symfony\Contracts\EventDispatcher\Event
{
    protected $command;
    private $input;
    private $output;
    public function __construct(?\ConfigTransformer202201177\Symfony\Component\Console\Command\Command $command, \ConfigTransformer202201177\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer202201177\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->command = $command;
        $this->input = $input;
        $this->output = $output;
    }
    /**
     * Gets the command that is executed.
     */
    public function getCommand() : ?\ConfigTransformer202201177\Symfony\Component\Console\Command\Command
    {
        return $this->command;
    }
    /**
     * Gets the input instance.
     */
    public function getInput() : \ConfigTransformer202201177\Symfony\Component\Console\Input\InputInterface
    {
        return $this->input;
    }
    /**
     * Gets the output instance.
     */
    public function getOutput() : \ConfigTransformer202201177\Symfony\Component\Console\Output\OutputInterface
    {
        return $this->output;
    }
}
