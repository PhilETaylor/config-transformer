<?php

declare (strict_types=1);
namespace ConfigTransformer202111029\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202111029\PhpParser\Node;
use ConfigTransformer202111029\PhpParser\Node\Stmt\Return_;
use ConfigTransformer202111029\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use ConfigTransformer202111029\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
/**
 * @api
 */
final class RoutingConfiguratorReturnClosureFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory
     */
    private $containerConfiguratorClosureNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface[]
     */
    private $routingCaseConverters;
    /**
     * @param RoutingCaseConverterInterface[] $routingCaseConverters
     */
    public function __construct(\ConfigTransformer202111029\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory $containerConfiguratorClosureNodeFactory, array $routingCaseConverters)
    {
        $this->containerConfiguratorClosureNodeFactory = $containerConfiguratorClosureNodeFactory;
        $this->routingCaseConverters = $routingCaseConverters;
    }
    public function createFromArrayData(array $arrayData) : \ConfigTransformer202111029\PhpParser\Node\Stmt\Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->containerConfiguratorClosureNodeFactory->createRoutingClosureFromStmts($stmts);
        return new \ConfigTransformer202111029\PhpParser\Node\Stmt\Return_($closure);
    }
    /**
     * @return mixed[]
     */
    private function createClosureStmts(array $arrayData) : array
    {
        $arrayData = $this->removeEmptyValues($arrayData);
        return $this->createNodesFromCaseConverters($arrayData);
    }
    /**
     * @return mixed[]
     */
    private function removeEmptyValues(array $yamlData) : array
    {
        return \array_filter($yamlData);
    }
    /**
     * @param mixed[] $arrayData
     * @return Node[]
     */
    private function createNodesFromCaseConverters(array $arrayData) : array
    {
        $nodes = [];
        foreach ($arrayData as $key => $values) {
            $expression = null;
            foreach ($this->routingCaseConverters as $routingCaseConverter) {
                if (!$routingCaseConverter->match($key, $values)) {
                    continue;
                }
                $expression = $routingCaseConverter->convertToMethodCall($key, $values);
                break;
            }
            if ($expression === null) {
                continue;
            }
            $nodes[] = $expression;
        }
        return $nodes;
    }
}
