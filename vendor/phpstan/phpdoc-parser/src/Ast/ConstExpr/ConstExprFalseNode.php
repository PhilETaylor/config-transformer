<?php

declare (strict_types=1);
namespace ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprFalseNode implements \ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'false';
    }
}
