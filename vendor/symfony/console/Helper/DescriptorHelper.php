<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202204171\Symfony\Component\Console\Helper;

use ConfigTransformer202204171\Symfony\Component\Console\Descriptor\DescriptorInterface;
use ConfigTransformer202204171\Symfony\Component\Console\Descriptor\JsonDescriptor;
use ConfigTransformer202204171\Symfony\Component\Console\Descriptor\MarkdownDescriptor;
use ConfigTransformer202204171\Symfony\Component\Console\Descriptor\TextDescriptor;
use ConfigTransformer202204171\Symfony\Component\Console\Descriptor\XmlDescriptor;
use ConfigTransformer202204171\Symfony\Component\Console\Exception\InvalidArgumentException;
use ConfigTransformer202204171\Symfony\Component\Console\Output\OutputInterface;
/**
 * This class adds helper method to describe objects in various formats.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DescriptorHelper extends \ConfigTransformer202204171\Symfony\Component\Console\Helper\Helper
{
    /**
     * @var DescriptorInterface[]
     */
    private $descriptors = [];
    public function __construct()
    {
        $this->register('txt', new \ConfigTransformer202204171\Symfony\Component\Console\Descriptor\TextDescriptor())->register('xml', new \ConfigTransformer202204171\Symfony\Component\Console\Descriptor\XmlDescriptor())->register('json', new \ConfigTransformer202204171\Symfony\Component\Console\Descriptor\JsonDescriptor())->register('md', new \ConfigTransformer202204171\Symfony\Component\Console\Descriptor\MarkdownDescriptor());
    }
    /**
     * Describes an object if supported.
     *
     * Available options are:
     * * format: string, the output format name
     * * raw_text: boolean, sets output type as raw
     *
     * @throws InvalidArgumentException when the given format is not supported
     * @param object|null $object
     */
    public function describe(\ConfigTransformer202204171\Symfony\Component\Console\Output\OutputInterface $output, $object, array $options = [])
    {
        $options = \array_merge(['raw_text' => \false, 'format' => 'txt'], $options);
        if (!isset($this->descriptors[$options['format']])) {
            throw new \ConfigTransformer202204171\Symfony\Component\Console\Exception\InvalidArgumentException(\sprintf('Unsupported format "%s".', $options['format']));
        }
        $descriptor = $this->descriptors[$options['format']];
        $descriptor->describe($output, $object, $options);
    }
    /**
     * Registers a descriptor.
     *
     * @return $this
     */
    public function register(string $format, \ConfigTransformer202204171\Symfony\Component\Console\Descriptor\DescriptorInterface $descriptor)
    {
        $this->descriptors[$format] = $descriptor;
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return 'descriptor';
    }
    public function getFormats() : array
    {
        return \array_keys($this->descriptors);
    }
}
