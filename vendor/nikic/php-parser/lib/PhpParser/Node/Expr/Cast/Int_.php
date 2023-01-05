<?php

declare (strict_types=1);
namespace ConfigTransformer202301\PhpParser\Node\Expr\Cast;

use ConfigTransformer202301\PhpParser\Node\Expr\Cast;
class Int_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
