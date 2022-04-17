<?php

declare (strict_types=1);
namespace ConfigTransformer202204175\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202204175\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprFalseNode implements \ConfigTransformer202204175\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'false';
    }
}
