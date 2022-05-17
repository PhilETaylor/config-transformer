<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022051710\PhpParser\Node;
use ConfigTransformer2022051710\PhpParser\Node\Attribute;
use ConfigTransformer2022051710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer2022051710\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022051710\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022051710\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer2022051710\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
