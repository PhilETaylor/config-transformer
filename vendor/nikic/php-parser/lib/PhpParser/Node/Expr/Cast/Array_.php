<?php

declare (strict_types=1);
namespace ConfigTransformer202111301\PhpParser\Node\Expr\Cast;

use ConfigTransformer202111301\PhpParser\Node\Expr\Cast;
class Array_ extends \ConfigTransformer202111301\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Array';
    }
}
