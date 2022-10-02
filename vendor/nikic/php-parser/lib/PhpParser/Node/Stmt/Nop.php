<?php

declare (strict_types=1);
namespace ConfigTransformer202210\PhpParser\Node\Stmt;

use ConfigTransformer202210\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends Node\Stmt
{
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Stmt_Nop';
    }
}
