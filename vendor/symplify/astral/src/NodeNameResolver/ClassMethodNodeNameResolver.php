<?php

declare (strict_types=1);
namespace ConfigTransformer202201177\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201177\PhpParser\Node;
use ConfigTransformer202201177\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202201177\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202201177\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201177\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202201177\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer202201177\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
