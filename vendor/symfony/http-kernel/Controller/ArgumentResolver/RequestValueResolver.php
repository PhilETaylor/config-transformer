<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021062210\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer2021062210\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use ConfigTransformer2021062210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields the same instance as the request object passed along.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class RequestValueResolver implements \ConfigTransformer2021062210\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(\ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer2021062210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        return \ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request::class === $argument->getType() || \is_subclass_of($argument->getType(), \ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request::class);
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(\ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer2021062210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : iterable
    {
        (yield $request);
    }
}
