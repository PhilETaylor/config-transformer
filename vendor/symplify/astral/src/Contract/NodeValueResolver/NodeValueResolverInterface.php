<?php

declare (strict_types=1);
namespace ConfigTransformer202110029\Symplify\Astral\Contract\NodeValueResolver;

use ConfigTransformer202110029\PhpParser\Node\Expr;
/**
 * @template TExpr as Expr
 */
interface NodeValueResolverInterface
{
    /**
     * @return class-string<TExpr>
     */
    public function getType() : string;
    /**
     * @param \PhpParser\Node\Expr $expr
     * @return mixed
     * @param string $currentFilePath
     */
    public function resolve($expr, $currentFilePath);
}
