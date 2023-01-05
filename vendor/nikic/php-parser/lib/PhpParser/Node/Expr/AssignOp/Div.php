<?php

declare (strict_types=1);
namespace ConfigTransformer202301\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202301\PhpParser\Node\Expr\AssignOp;
class Div extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Div';
    }
}
