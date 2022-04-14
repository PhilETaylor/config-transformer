<?php

declare (strict_types=1);
namespace ConfigTransformer202204146\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202204146\PhpParser\Node\Scalar\MagicConst;
class Trait_ extends \ConfigTransformer202204146\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__TRAIT__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Trait';
    }
}
