<?php

declare (strict_types=1);
namespace ConfigTransformer202205313\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202205313\PhpParser\Node\Expr\AssignOp;
class BitwiseAnd extends \ConfigTransformer202205313\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseAnd';
    }
}
