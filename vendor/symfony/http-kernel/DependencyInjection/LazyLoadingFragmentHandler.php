<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110242\Symfony\Component\HttpKernel\DependencyInjection;

use ConfigTransformer202110242\Psr\Container\ContainerInterface;
use ConfigTransformer202110242\Symfony\Component\HttpFoundation\RequestStack;
use ConfigTransformer202110242\Symfony\Component\HttpKernel\Fragment\FragmentHandler;
/**
 * Lazily loads fragment renderers from the dependency injection container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LazyLoadingFragmentHandler extends \ConfigTransformer202110242\Symfony\Component\HttpKernel\Fragment\FragmentHandler
{
    private $container;
    private $initialized = [];
    public function __construct(\ConfigTransformer202110242\Psr\Container\ContainerInterface $container, \ConfigTransformer202110242\Symfony\Component\HttpFoundation\RequestStack $requestStack, bool $debug = \false)
    {
        $this->container = $container;
        parent::__construct($requestStack, [], $debug);
    }
    /**
     * {@inheritdoc}
     * @param string $renderer
     * @param mixed[] $options
     */
    public function render($uri, $renderer = 'inline', $options = [])
    {
        if (!isset($this->initialized[$renderer]) && $this->container->has($renderer)) {
            $this->addRenderer($this->container->get($renderer));
            $this->initialized[$renderer] = \true;
        }
        return parent::render($uri, $renderer, $options);
    }
}
