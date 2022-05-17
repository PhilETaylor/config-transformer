<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer2022051710\PhpParser\ConstExprEvaluator;
use ConfigTransformer2022051710\PhpParser\Node\Expr;
use ConfigTransformer2022051710\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2022051710\PhpParser\Node\Name;
use ConfigTransformer2022051710\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer2022051710\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer2022051710\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<FuncCall>
 */
final class FuncCallValueResolver implements \ConfigTransformer2022051710\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var string[]
     */
    private const EXCLUDED_FUNC_NAMES = ['pg_*'];
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \PhpParser\ConstExprEvaluator
     */
    private $constExprEvaluator;
    public function __construct(\ConfigTransformer2022051710\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer2022051710\PhpParser\ConstExprEvaluator $constExprEvaluator)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->constExprEvaluator = $constExprEvaluator;
    }
    public function getType() : string
    {
        return \ConfigTransformer2022051710\PhpParser\Node\Expr\FuncCall::class;
    }
    /**
     * @param FuncCall $expr
     * @return mixed
     */
    public function resolve(\ConfigTransformer2022051710\PhpParser\Node\Expr $expr, string $currentFilePath)
    {
        if ($this->simpleNameResolver->isName($expr, 'getcwd')) {
            return \dirname($currentFilePath);
        }
        $args = $expr->getArgs();
        $arguments = [];
        foreach ($args as $arg) {
            $arguments[] = $this->constExprEvaluator->evaluateDirectly($arg->value);
        }
        if ($expr->name instanceof \ConfigTransformer2022051710\PhpParser\Node\Name) {
            $functionName = (string) $expr->name;
            if (!$this->isAllowedFunctionName($functionName)) {
                return null;
            }
            if (\function_exists($functionName)) {
                return $functionName(...$arguments);
            }
            throw new \ConfigTransformer2022051710\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        return null;
    }
    private function isAllowedFunctionName(string $functionName) : bool
    {
        foreach (self::EXCLUDED_FUNC_NAMES as $excludedFuncName) {
            if (\fnmatch($excludedFuncName, $functionName, \FNM_NOESCAPE)) {
                return \false;
            }
        }
        return \true;
    }
}
