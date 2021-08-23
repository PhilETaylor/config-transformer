<?php

namespace ConfigTransformer202108239;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
$operators = ['not', '!', 'or', '||', '&&', 'and', '|', '^', '&', '==', '===', '!=', '!==', '<', '>', '>=', '<=', 'not in', 'in', '..', '+', '-', '~', '*', '/', '%', 'matches', '**'];
$operators = \array_combine($operators, \array_map('strlen', $operators));
\arsort($operators);
$regex = [];
foreach ($operators as $operator => $length) {
    // Collisions of character operators:
    // - an operator that begins with a character must have a space or a parenthesis before or starting at the beginning of a string
    // - an operator that ends with a character must be followed by a whitespace or a parenthesis
    $regex[] = (\ctype_alpha($operator[0]) ? '(?<=^|[\\s(])' : '') . \preg_quote($operator, '/') . (\ctype_alpha($operator[$length - 1]) ? '(?=[\\s(])' : '');
}
echo '/' . \implode('|', $regex) . '/A';
