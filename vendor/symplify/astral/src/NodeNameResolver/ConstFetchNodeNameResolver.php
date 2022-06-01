<?php

declare (strict_types=1);
namespace ConfigTransformer202206011\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206011\PhpParser\Node;
use ConfigTransformer202206011\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202206011\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202206011\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206011\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202206011\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202206011\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
