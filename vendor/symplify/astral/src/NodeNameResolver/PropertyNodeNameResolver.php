<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022051710\PhpParser\Node;
use ConfigTransformer2022051710\PhpParser\Node\Stmt\Property;
use ConfigTransformer2022051710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer2022051710\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022051710\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022051710\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer2022051710\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
