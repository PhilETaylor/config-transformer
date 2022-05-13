<?php

declare (strict_types=1);
namespace ConfigTransformer202205135\PhpParser\ErrorHandler;

use ConfigTransformer202205135\PhpParser\Error;
use ConfigTransformer202205135\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202205135\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202205135\PhpParser\Error $error)
    {
        throw $error;
    }
}
