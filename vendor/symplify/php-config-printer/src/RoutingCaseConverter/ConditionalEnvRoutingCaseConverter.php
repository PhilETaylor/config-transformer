<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\RoutingCaseConverter;

use ConfigTransformer202301\Nette\Utils\Strings;
use ConfigTransformer202301\PhpParser\Node\Expr\BinaryOp\Identical;
use ConfigTransformer202301\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202301\PhpParser\Node\Expr\Variable;
use ConfigTransformer202301\PhpParser\Node\Scalar\String_;
use ConfigTransformer202301\PhpParser\Node\Stmt;
use ConfigTransformer202301\PhpParser\Node\Stmt\If_;
use ConfigTransformer202301\Symfony\Contracts\Service\Attribute\Required;
use Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ConditionalEnvRoutingCaseConverter implements RoutingCaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory
     */
    private $routingConfiguratorReturnClosureFactory;
    /**
     * @required
     */
    public function autowire(RoutingConfiguratorReturnClosureFactory $routingConfiguratorReturnClosureFactory) : void
    {
        $this->routingConfiguratorReturnClosureFactory = $routingConfiguratorReturnClosureFactory;
    }
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool
    {
        return \strncmp($key, 'when@', \strlen('when@')) === 0;
    }
    /**
     * Mirror to https://github.com/symplify/symplify/pull/4179/files, just for routes
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : Stmt
    {
        /** @var string $environment */
        $environment = Strings::after($key, 'when@');
        $variable = new Variable(VariableName::ROUTING_CONFIGURATOR);
        $identical = new Identical(new MethodCall($variable, 'env'), new String_($environment));
        $stmts = $this->routingConfiguratorReturnClosureFactory->createClosureStmts($values);
        return new If_($identical, ['stmts' => $stmts]);
    }
}
