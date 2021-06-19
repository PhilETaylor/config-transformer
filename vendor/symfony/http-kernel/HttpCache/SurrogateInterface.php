<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202106196\Symfony\Component\HttpKernel\HttpCache;

use ConfigTransformer202106196\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202106196\Symfony\Component\HttpFoundation\Response;
interface SurrogateInterface
{
    /**
     * Returns surrogate name.
     *
     * @return string
     */
    public function getName();
    /**
     * Returns a new cache strategy instance.
     *
     * @return ResponseCacheStrategyInterface A ResponseCacheStrategyInterface instance
     */
    public function createCacheStrategy();
    /**
     * Checks that at least one surrogate has Surrogate capability.
     *
     * @return bool true if one surrogate has Surrogate capability, false otherwise
     */
    public function hasSurrogateCapability(\ConfigTransformer202106196\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Adds Surrogate-capability to the given Request.
     */
    public function addSurrogateCapability(\ConfigTransformer202106196\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Adds HTTP headers to specify that the Response needs to be parsed for Surrogate.
     *
     * This method only adds an Surrogate HTTP header if the Response has some Surrogate tags.
     */
    public function addSurrogateControl(\ConfigTransformer202106196\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Checks that the Response needs to be parsed for Surrogate tags.
     *
     * @return bool true if the Response needs to be parsed, false otherwise
     */
    public function needsParsing(\ConfigTransformer202106196\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Renders a Surrogate tag.
     *
     * @param string $alt     An alternate URI
     * @param string $comment A comment to add as an esi:include tag
     *
     * @return string
     */
    public function renderIncludeTag(string $uri, string $alt = null, bool $ignoreErrors = \true, string $comment = '');
    /**
     * Replaces a Response Surrogate tags with the included resource content.
     *
     * @return Response
     */
    public function process(\ConfigTransformer202106196\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer202106196\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Handles a Surrogate from the cache.
     *
     * @param string $alt An alternative URI
     *
     * @return string
     *
     * @throws \RuntimeException
     * @throws \Exception
     */
    public function handle(\ConfigTransformer202106196\Symfony\Component\HttpKernel\HttpCache\HttpCache $cache, string $uri, string $alt, bool $ignoreErrors);
}
