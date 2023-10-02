<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310\PhpParser\Node\Expr\AssignOp;

use ConfigTransformerPrefix202310\PhpParser\Node\Expr\AssignOp;
class Minus extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Minus';
    }
}
