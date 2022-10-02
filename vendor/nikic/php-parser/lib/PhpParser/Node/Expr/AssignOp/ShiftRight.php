<?php

declare (strict_types=1);
namespace ConfigTransformer202210\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202210\PhpParser\Node\Expr\AssignOp;
class ShiftRight extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_ShiftRight';
    }
}
