<?php

declare (strict_types=1);
namespace ConfigTransformer202107050\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202107050\PhpParser\Node\Scalar\MagicConst;
class Line extends \ConfigTransformer202107050\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__LINE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Line';
    }
}
