<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112073\Symfony\Component\DependencyInjection\Compiler;

use ConfigTransformer202112073\Symfony\Component\DependencyInjection\Argument\ArgumentInterface;
use ConfigTransformer202112073\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202112073\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202112073\Symfony\Component\DependencyInjection\Reference;
/**
 * Propagate "container.hot_path" tags to referenced services.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ResolveHotPathPass extends \ConfigTransformer202112073\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    /**
     * @var mixed[]
     */
    private $resolvedIds = [];
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process($container)
    {
        try {
            parent::process($container);
            $container->getDefinition('service_container')->clearTag('container.hot_path');
        } finally {
            $this->resolvedIds = [];
        }
    }
    /**
     * {@inheritdoc}
     * @param mixed $value
     * @return mixed
     * @param bool $isRoot
     */
    protected function processValue($value, $isRoot = \false)
    {
        if ($value instanceof \ConfigTransformer202112073\Symfony\Component\DependencyInjection\Argument\ArgumentInterface) {
            return $value;
        }
        if ($value instanceof \ConfigTransformer202112073\Symfony\Component\DependencyInjection\Definition && $isRoot) {
            if ($value->isDeprecated()) {
                return $value->clearTag('container.hot_path');
            }
            $this->resolvedIds[$this->currentId] = \true;
            if (!$value->hasTag('container.hot_path')) {
                return $value;
            }
        }
        if ($value instanceof \ConfigTransformer202112073\Symfony\Component\DependencyInjection\Reference && \ConfigTransformer202112073\Symfony\Component\DependencyInjection\ContainerBuilder::IGNORE_ON_UNINITIALIZED_REFERENCE !== $value->getInvalidBehavior() && $this->container->hasDefinition($id = (string) $value)) {
            $definition = $this->container->getDefinition($id);
            if ($definition->isDeprecated() || $definition->hasTag('container.hot_path')) {
                return $value;
            }
            $definition->addTag('container.hot_path');
            if (isset($this->resolvedIds[$id])) {
                parent::processValue($definition, \false);
            }
            return $value;
        }
        return parent::processValue($value, $isRoot);
    }
}
