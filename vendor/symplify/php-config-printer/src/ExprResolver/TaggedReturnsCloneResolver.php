<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202301\PhpParser\Node\Expr\Array_;
use ConfigTransformer202301\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202301\Symfony\Component\Yaml\Tag\TaggedValue;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedReturnsCloneResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(TaggedValue $taggedValue) : Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $expr = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, FunctionName::SERVICE);
        return new Array_([new ArrayItem($expr)]);
    }
}
