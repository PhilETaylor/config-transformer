<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108221\Symfony\Component\Console\Descriptor;

use ConfigTransformer202108221\Symfony\Component\Console\Application;
use ConfigTransformer202108221\Symfony\Component\Console\Command\Command;
use ConfigTransformer202108221\Symfony\Component\Console\Exception\InvalidArgumentException;
use ConfigTransformer202108221\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer202108221\Symfony\Component\Console\Input\InputDefinition;
use ConfigTransformer202108221\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer202108221\Symfony\Component\Console\Output\OutputInterface;
/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
abstract class Descriptor implements \ConfigTransformer202108221\Symfony\Component\Console\Descriptor\DescriptorInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * {@inheritdoc}
     * @param object $object
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param mixed[] $options
     */
    public function describe($output, $object, $options = [])
    {
        $this->output = $output;
        switch (\true) {
            case $object instanceof \ConfigTransformer202108221\Symfony\Component\Console\Input\InputArgument:
                $this->describeInputArgument($object, $options);
                break;
            case $object instanceof \ConfigTransformer202108221\Symfony\Component\Console\Input\InputOption:
                $this->describeInputOption($object, $options);
                break;
            case $object instanceof \ConfigTransformer202108221\Symfony\Component\Console\Input\InputDefinition:
                $this->describeInputDefinition($object, $options);
                break;
            case $object instanceof \ConfigTransformer202108221\Symfony\Component\Console\Command\Command:
                $this->describeCommand($object, $options);
                break;
            case $object instanceof \ConfigTransformer202108221\Symfony\Component\Console\Application:
                $this->describeApplication($object, $options);
                break;
            default:
                throw new \ConfigTransformer202108221\Symfony\Component\Console\Exception\InvalidArgumentException(\sprintf('Object of type "%s" is not describable.', \get_debug_type($object)));
        }
    }
    /**
     * Writes content to output.
     * @param string $content
     * @param bool $decorated
     */
    protected function write($content, $decorated = \false)
    {
        $this->output->write($content, \false, $decorated ? \ConfigTransformer202108221\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL : \ConfigTransformer202108221\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
    }
    /**
     * Describes an InputArgument instance.
     * @param \Symfony\Component\Console\Input\InputArgument $argument
     * @param mixed[] $options
     */
    protected abstract function describeInputArgument($argument, $options = []);
    /**
     * Describes an InputOption instance.
     * @param \Symfony\Component\Console\Input\InputOption $option
     * @param mixed[] $options
     */
    protected abstract function describeInputOption($option, $options = []);
    /**
     * Describes an InputDefinition instance.
     * @param \Symfony\Component\Console\Input\InputDefinition $definition
     * @param mixed[] $options
     */
    protected abstract function describeInputDefinition($definition, $options = []);
    /**
     * Describes a Command instance.
     * @param \Symfony\Component\Console\Command\Command $command
     * @param mixed[] $options
     */
    protected abstract function describeCommand($command, $options = []);
    /**
     * Describes an Application instance.
     * @param \Symfony\Component\Console\Application $application
     * @param mixed[] $options
     */
    protected abstract function describeApplication($application, $options = []);
}
