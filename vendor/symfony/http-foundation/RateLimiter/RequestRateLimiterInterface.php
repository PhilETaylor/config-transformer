<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110318\Symfony\Component\HttpFoundation\RateLimiter;

use ConfigTransformer202110318\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202110318\Symfony\Component\RateLimiter\RateLimit;
/**
 * A special type of limiter that deals with requests.
 *
 * This allows to limit on different types of information
 * from the requests.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 *
 * @experimental in 5.3
 */
interface RequestRateLimiterInterface
{
    public function consume(\ConfigTransformer202110318\Symfony\Component\HttpFoundation\Request $request) : \ConfigTransformer202110318\Symfony\Component\RateLimiter\RateLimit;
    public function reset(\ConfigTransformer202110318\Symfony\Component\HttpFoundation\Request $request) : void;
}
