<?php

declare (strict_types=1);
namespace ConfigTransformer202201177\PhpParser\ErrorHandler;

use ConfigTransformer202201177\PhpParser\Error;
use ConfigTransformer202201177\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202201177\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202201177\PhpParser\Error $error)
    {
        throw $error;
    }
}
