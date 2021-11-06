<?php

declare (strict_types=1);
namespace ConfigTransformer202111061\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202111061\PhpParser\Node\Expr\Array_;
use ConfigTransformer202111061\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202111061\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202111061\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedReturnsCloneResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202111061\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202111061\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202111061\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, \ConfigTransformer202111061\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE);
        return new \ConfigTransformer202111061\PhpParser\Node\Expr\Array_([new \ConfigTransformer202111061\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
