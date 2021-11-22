<?php

declare (strict_types=1);
namespace ConfigTransformer2021112210\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021112210\PhpParser\Node\Expr\AssignOp;
class BitwiseXor extends \ConfigTransformer2021112210\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseXor';
    }
}
