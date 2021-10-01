<?php

declare (strict_types=1);
namespace ConfigTransformer202110016\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer202110016\PhpParser\Lexer\Emulative;
final class EnumTokenEmulator extends \ConfigTransformer202110016\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \ConfigTransformer202110016\PhpParser\Lexer\Emulative::PHP_8_1;
    }
    public function getKeywordString() : string
    {
        return 'enum';
    }
    public function getKeywordToken() : int
    {
        return \T_ENUM;
    }
    /**
     * @param mixed[] $tokens
     * @param int $pos
     */
    protected function isKeywordContext($tokens, $pos) : bool
    {
        return parent::isKeywordContext($tokens, $pos) && isset($tokens[$pos + 2]) && $tokens[$pos + 1][0] === \T_WHITESPACE && $tokens[$pos + 2][0] === \T_STRING;
    }
}
