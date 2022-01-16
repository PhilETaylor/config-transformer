<?php

declare (strict_types=1);
namespace ConfigTransformer202201163\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201163\PhpParser\Node;
use ConfigTransformer202201163\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer202201163\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer202201163\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201163\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202201163\PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(\ConfigTransformer202201163\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
