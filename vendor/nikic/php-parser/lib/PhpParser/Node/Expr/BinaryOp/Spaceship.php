<?php

declare (strict_types=1);
namespace ConfigTransformer202206046\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202206046\PhpParser\Node\Expr\BinaryOp;
class Spaceship extends \ConfigTransformer202206046\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<=>';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Spaceship';
    }
}
