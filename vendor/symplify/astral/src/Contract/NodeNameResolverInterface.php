<?php

declare (strict_types=1);
namespace ConfigTransformer202112313\Symplify\Astral\Contract;

use ConfigTransformer202112313\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112313\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112313\PhpParser\Node $node) : ?string;
}
