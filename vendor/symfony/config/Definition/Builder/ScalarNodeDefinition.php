<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112195\Symfony\Component\Config\Definition\Builder;

use ConfigTransformer202112195\Symfony\Component\Config\Definition\ScalarNode;
/**
 * This class provides a fluent interface for defining a node.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ScalarNodeDefinition extends \ConfigTransformer202112195\Symfony\Component\Config\Definition\Builder\VariableNodeDefinition
{
    /**
     * Instantiate a Node.
     */
    protected function instantiateNode() : \ConfigTransformer202112195\Symfony\Component\Config\Definition\VariableNode
    {
        return new \ConfigTransformer202112195\Symfony\Component\Config\Definition\ScalarNode($this->name, $this->parent, $this->pathSeparator);
    }
}
