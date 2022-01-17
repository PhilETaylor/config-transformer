<?php

declare (strict_types=1);
namespace ConfigTransformer202201177\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201177\PhpParser\Node;
use ConfigTransformer202201177\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202201177\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer202201177\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201177\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202201177\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(\ConfigTransformer202201177\PhpParser\Node $node) : ?string
    {
        if (\property_exists($node, 'namespacedName')) {
            return (string) $node->namespacedName;
        }
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
