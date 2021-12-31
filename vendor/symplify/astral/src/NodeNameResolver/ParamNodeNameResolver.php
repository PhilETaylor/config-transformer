<?php

declare (strict_types=1);
namespace ConfigTransformer202112319\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112319\PhpParser\Node;
use ConfigTransformer202112319\PhpParser\Node\Expr;
use ConfigTransformer202112319\PhpParser\Node\Param;
use ConfigTransformer202112319\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \ConfigTransformer202112319\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112319\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202112319\PhpParser\Node\Param;
    }
    /**
     * @param Param $node
     */
    public function resolve(\ConfigTransformer202112319\PhpParser\Node $node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \ConfigTransformer202112319\PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
