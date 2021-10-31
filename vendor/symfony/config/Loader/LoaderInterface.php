<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110318\Symfony\Component\Config\Loader;

/**
 * LoaderInterface is the interface implemented by all loader classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface LoaderInterface
{
    /**
     * Loads a resource.
     *
     * @param mixed $resource The resource
     *
     * @return mixed
     *
     * @throws \Exception If something went wrong
     * @param string|null $type
     */
    public function load($resource, $type = null);
    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     *
     * @return bool True if this class supports the given resource, false otherwise
     * @param string|null $type
     */
    public function supports($resource, $type = null);
    /**
     * Gets the loader resolver.
     *
     * @return LoaderResolverInterface A LoaderResolverInterface instance
     */
    public function getResolver();
    /**
     * Sets the loader resolver.
     * @param \Symfony\Component\Config\Loader\LoaderResolverInterface $resolver
     */
    public function setResolver($resolver);
}
