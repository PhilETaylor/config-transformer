<?php

declare (strict_types=1);
namespace ConfigTransformer202204146\PhpParser\Node\Expr\Cast;

use ConfigTransformer202204146\PhpParser\Node\Expr\Cast;
class Int_ extends \ConfigTransformer202204146\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
