<?php

declare (strict_types=1);
namespace ConfigTransformer202112023\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202112023\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    /**
     * @param mixed $key
     * @param mixed $values
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool;
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202112023\PhpParser\Node\Stmt\Expression;
}
