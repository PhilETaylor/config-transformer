<?php

declare (strict_types=1);
namespace ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function sprintf;
class ConditionalTypeForParameterNode implements \ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var string */
    public $parameterName;
    /** @var TypeNode */
    public $targetType;
    /** @var TypeNode */
    public $if;
    /** @var TypeNode */
    public $else;
    /** @var bool */
    public $negated;
    public function __construct(string $parameterName, \ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\Type\TypeNode $targetType, \ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\Type\TypeNode $if, \ConfigTransformer202206021\PHPStan\PhpDocParser\Ast\Type\TypeNode $else, bool $negated)
    {
        $this->parameterName = $parameterName;
        $this->targetType = $targetType;
        $this->if = $if;
        $this->else = $else;
        $this->negated = $negated;
    }
    public function __toString() : string
    {
        return \sprintf('(%s %s %s ? %s : %s)', $this->parameterName, $this->negated ? 'is not' : 'is', $this->targetType, $this->if, $this->else);
    }
}
