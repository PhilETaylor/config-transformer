<?php

declare (strict_types=1);
namespace ConfigTransformer202112079\PhpParser\Node\Expr\Cast;

use ConfigTransformer202112079\PhpParser\Node\Expr\Cast;
class Array_ extends \ConfigTransformer202112079\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Array';
    }
}
