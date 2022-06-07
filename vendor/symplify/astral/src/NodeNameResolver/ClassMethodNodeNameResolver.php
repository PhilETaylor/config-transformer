<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206077\PhpParser\Node;
use ConfigTransformer202206077\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202206077\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(Node $node) : ?string
    {
        return $node->name->toString();
    }
}
