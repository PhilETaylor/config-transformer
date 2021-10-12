<?php

declare (strict_types=1);
namespace ConfigTransformer202110125\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202110125\PhpParser\Node\Expr\BinaryOp;
class BooleanAnd extends \ConfigTransformer202110125\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '&&';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BooleanAnd';
    }
}
