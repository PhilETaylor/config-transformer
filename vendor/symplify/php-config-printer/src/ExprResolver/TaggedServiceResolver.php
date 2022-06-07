<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202206077\PhpParser\Node\Expr;
use ConfigTransformer202206077\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(TaggedValue $taggedValue) : Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, FunctionName::INLINE_SERVICE);
    }
}
