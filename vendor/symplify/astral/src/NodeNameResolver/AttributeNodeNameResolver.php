<?php

declare (strict_types=1);
namespace ConfigTransformer202109042\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202109042\PhpParser\Node;
use ConfigTransformer202109042\PhpParser\Node\Attribute;
use ConfigTransformer202109042\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202109042\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202109042\PhpParser\Node\Attribute;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
