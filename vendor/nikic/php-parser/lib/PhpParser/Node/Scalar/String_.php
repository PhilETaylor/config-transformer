<?php

declare (strict_types=1);
namespace ConfigTransformer2021112210\PhpParser\Node\Scalar;

use ConfigTransformer2021112210\PhpParser\Error;
use ConfigTransformer2021112210\PhpParser\Node\Scalar;
class String_ extends \ConfigTransformer2021112210\PhpParser\Node\Scalar
{
    /* For use in "kind" attribute */
    const KIND_SINGLE_QUOTED = 1;
    const KIND_DOUBLE_QUOTED = 2;
    const KIND_HEREDOC = 3;
    const KIND_NOWDOC = 4;
    /** @var string String value */
    public $value;
    protected static $replacements = ['\\' => '\\', '$' => '$', 'n' => "\n", 'r' => "\r", 't' => "\t", 'f' => "\f", 'v' => "\v", 'e' => "\33"];
    /**
     * Constructs a string scalar node.
     *
     * @param string $value      Value of the string
     * @param array  $attributes Additional attributes
     */
    public function __construct(string $value, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->value = $value;
    }
    public function getSubNodeNames() : array
    {
        return ['value'];
    }
    /**
     * @internal
     *
     * Parses a string token.
     *
     * @param string $str String token content
     * @param bool $parseUnicodeEscape Whether to parse PHP 7 \u escapes
     *
     * @return string The parsed string
     */
    public static function parse($str, $parseUnicodeEscape = \true) : string
    {
        $bLength = 0;
        if ('b' === $str[0] || 'B' === $str[0]) {
            $bLength = 1;
        }
        if ('\'' === $str[$bLength]) {
            return \str_replace(['\\\\', '\\\''], ['\\', '\''], \substr($str, $bLength + 1, -1));
        } else {
            return self::parseEscapeSequences(\substr($str, $bLength + 1, -1), '"', $parseUnicodeEscape);
        }
    }
    /**
     * @internal
     *
     * Parses escape sequences in strings (all string types apart from single quoted).
     *
     * @param string      $str   String without quotes
     * @param null|string $quote Quote type
     * @param bool $parseUnicodeEscape Whether to parse PHP 7 \u escapes
     *
     * @return string String with escape sequences parsed
     */
    public static function parseEscapeSequences($str, $quote, $parseUnicodeEscape = \true) : string
    {
        if (null !== $quote) {
            $str = \str_replace('\\' . $quote, $quote, $str);
        }
        $extra = '';
        if ($parseUnicodeEscape) {
            $extra = '|u\\{([0-9a-fA-F]+)\\}';
        }
        return \preg_replace_callback('~\\\\([\\\\$nrtfve]|[xX][0-9a-fA-F]{1,2}|[0-7]{1,3}' . $extra . ')~', function ($matches) {
            $str = $matches[1];
            if (isset(self::$replacements[$str])) {
                return self::$replacements[$str];
            } elseif ('x' === $str[0] || 'X' === $str[0]) {
                return \chr(\hexdec(\substr($str, 1)));
            } elseif ('u' === $str[0]) {
                return self::codePointToUtf8(\hexdec($matches[2]));
            } else {
                return \chr(\octdec($str));
            }
        }, $str);
    }
    /**
     * Converts a Unicode code point to its UTF-8 encoded representation.
     *
     * @param int $num Code point
     *
     * @return string UTF-8 representation of code point
     */
    private static function codePointToUtf8(int $num) : string
    {
        if ($num <= 0x7f) {
            return \chr($num);
        }
        if ($num <= 0x7ff) {
            return \chr(($num >> 6) + 0xc0) . \chr(($num & 0x3f) + 0x80);
        }
        if ($num <= 0xffff) {
            return \chr(($num >> 12) + 0xe0) . \chr(($num >> 6 & 0x3f) + 0x80) . \chr(($num & 0x3f) + 0x80);
        }
        if ($num <= 0x1fffff) {
            return \chr(($num >> 18) + 0xf0) . \chr(($num >> 12 & 0x3f) + 0x80) . \chr(($num >> 6 & 0x3f) + 0x80) . \chr(($num & 0x3f) + 0x80);
        }
        throw new \ConfigTransformer2021112210\PhpParser\Error('Invalid UTF-8 codepoint escape sequence: Codepoint too large');
    }
    public function getType() : string
    {
        return 'Scalar_String';
    }
}
