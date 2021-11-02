<?php

declare (strict_types=1);
namespace ConfigTransformer202111029\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202111029\PhpParser\Node;
use ConfigTransformer202111029\PhpParser\Node\Identifier;
use ConfigTransformer202111029\PhpParser\Node\Name;
use ConfigTransformer202111029\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer202111029\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        if ($node instanceof \ConfigTransformer202111029\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer202111029\PhpParser\Node\Name;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return (string) $node;
    }
}
