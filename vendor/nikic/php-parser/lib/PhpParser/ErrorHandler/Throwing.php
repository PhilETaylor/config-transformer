<?php

declare (strict_types=1);
namespace ConfigTransformer202112313\PhpParser\ErrorHandler;

use ConfigTransformer202112313\PhpParser\Error;
use ConfigTransformer202112313\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202112313\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202112313\PhpParser\Error $error)
    {
        throw $error;
    }
}
