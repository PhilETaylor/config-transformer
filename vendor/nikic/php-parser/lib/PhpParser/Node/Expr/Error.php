<?php

declare (strict_types=1);
namespace ConfigTransformer202106196\PhpParser\Node\Expr;

use ConfigTransformer202106196\PhpParser\Node\Expr;
/**
 * Error node used during parsing with error recovery.
 *
 * An error node may be placed at a position where an expression is required, but an error occurred.
 * Error nodes will not be present if the parser is run in throwOnError mode (the default).
 */
class Error extends \ConfigTransformer202106196\PhpParser\Node\Expr
{
    /**
     * Constructs an error node.
     *
     * @param array $attributes Additional attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Expr_Error';
    }
}
