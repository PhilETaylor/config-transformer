<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021110310\Symfony\Component\ExpressionLanguage;

use ConfigTransformer2021110310\Symfony\Component\ExpressionLanguage\Node\Node;
/**
 * Represents an already parsed expression.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ParsedExpression extends \ConfigTransformer2021110310\Symfony\Component\ExpressionLanguage\Expression
{
    private $nodes;
    public function __construct(string $expression, \ConfigTransformer2021110310\Symfony\Component\ExpressionLanguage\Node\Node $nodes)
    {
        parent::__construct($expression);
        $this->nodes = $nodes;
    }
    public function getNodes()
    {
        return $this->nodes;
    }
}
