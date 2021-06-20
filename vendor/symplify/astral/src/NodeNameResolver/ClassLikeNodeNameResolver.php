<?php

declare (strict_types=1);
namespace ConfigTransformer202106207\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202106207\PhpParser\Node;
use ConfigTransformer202106207\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202106207\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer202106207\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106207\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202106207\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(\ConfigTransformer202106207\PhpParser\Node $node) : ?string
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
