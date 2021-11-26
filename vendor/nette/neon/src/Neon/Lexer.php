<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer202111267\Nette\Neon;

/** @internal */
final class Lexer
{
    public const PATTERNS = [
        // strings
        \ConfigTransformer202111267\Nette\Neon\Token::STRING => '
			\'\'\'\\n (?:(?: [^\\n] | \\n(?![\\t\\ ]*+\'\'\') )*+ \\n)?[\\t\\ ]*+\'\'\' |
			"""\\n (?:(?: [^\\n] | \\n(?![\\t\\ ]*+""") )*+ \\n)?[\\t\\ ]*+""" |
			\' (?: \'\' | [^\'\\n] )*+ \' |
			" (?: \\\\. | [^"\\\\\\n] )*+ "
		',
        // literal / boolean / integer / float
        \ConfigTransformer202111267\Nette\Neon\Token::LITERAL => '
			(?: [^#"\',:=[\\]{}()\\n\\t\\ `-] | (?<!["\']) [:-] [^"\',=[\\]{}()\\n\\t\\ ] )
			(?:
				[^,:=\\]})(\\n\\t\\ ]++ |
				:(?! [\\n\\t\\ ,\\]})] | $ ) |
				[\\ \\t]++ [^#,:=\\]})(\\n\\t\\ ]
			)*+
		',
        // punctuation
        \ConfigTransformer202111267\Nette\Neon\Token::CHAR => '[,:=[\\]{}()-]',
        // comment
        \ConfigTransformer202111267\Nette\Neon\Token::COMMENT => '\\#.*+',
        // new line
        \ConfigTransformer202111267\Nette\Neon\Token::NEWLINE => '\\n++',
        // whitespace
        \ConfigTransformer202111267\Nette\Neon\Token::WHITESPACE => '[\\t\\ ]++',
    ];
    public function tokenize(string $input) : \ConfigTransformer202111267\Nette\Neon\TokenStream
    {
        $input = \str_replace("\r", '', $input);
        $pattern = '~(' . \implode(')|(', self::PATTERNS) . ')~Amixu';
        $res = \preg_match_all($pattern, $input, $tokens, \PREG_SET_ORDER);
        if ($res === \false) {
            throw new \ConfigTransformer202111267\Nette\Neon\Exception('Invalid UTF-8 sequence.');
        }
        $types = \array_keys(self::PATTERNS);
        $offset = 0;
        foreach ($tokens as &$token) {
            $type = null;
            for ($i = 1; $i <= \count($types); $i++) {
                if (!isset($token[$i])) {
                    break;
                } elseif ($token[$i] !== '') {
                    $type = $types[$i - 1];
                    if ($type === \ConfigTransformer202111267\Nette\Neon\Token::CHAR) {
                        $type = $token[0];
                    }
                    break;
                }
            }
            $token = new \ConfigTransformer202111267\Nette\Neon\Token($token[0], $offset, $type);
            $offset += \strlen($token->value);
        }
        $stream = new \ConfigTransformer202111267\Nette\Neon\TokenStream($tokens);
        if ($offset !== \strlen($input)) {
            $s = \str_replace("\n", '\\n', \substr($input, $offset, 40));
            $stream->error("Unexpected '{$s}'", \count($tokens));
        }
        return $stream;
    }
    public static function requiresDelimiters(string $s) : bool
    {
        return \preg_match('~[\\x00-\\x1F]|^[+-.]?\\d|^(true|false|yes|no|on|off|null)$~Di', $s) || !\preg_match('~^' . self::PATTERNS[\ConfigTransformer202111267\Nette\Neon\Token::LITERAL] . '$~Dx', $s);
    }
}
