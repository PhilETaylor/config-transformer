<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022051710\PhpParser\Node;
use ConfigTransformer2022051710\PhpParser\Node\Identifier;
use ConfigTransformer2022051710\PhpParser\Node\Name;
use ConfigTransformer2022051710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer2022051710\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022051710\PhpParser\Node $node) : bool
    {
        if ($node instanceof \ConfigTransformer2022051710\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer2022051710\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(\ConfigTransformer2022051710\PhpParser\Node $node) : ?string
    {
        return (string) $node;
    }
}
