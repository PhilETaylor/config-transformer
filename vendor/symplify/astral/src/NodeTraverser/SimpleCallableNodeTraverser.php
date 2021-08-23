<?php

declare (strict_types=1);
namespace ConfigTransformer2021082310\Symplify\Astral\NodeTraverser;

use ConfigTransformer2021082310\PhpParser\Node;
use ConfigTransformer2021082310\PhpParser\Node\Expr;
use ConfigTransformer2021082310\PhpParser\Node\Stmt;
use ConfigTransformer2021082310\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021082310\PhpParser\NodeTraverser;
use ConfigTransformer2021082310\PhpParser\NodeVisitor;
use ConfigTransformer2021082310\PhpParser\NodeVisitorAbstract;
final class SimpleCallableNodeTraverser
{
    /**
     * @param Node|Node[]|null $nodes
     */
    public function traverseNodesWithCallable($nodes, callable $callable) : void
    {
        if ($nodes === null) {
            return;
        }
        if ($nodes === []) {
            return;
        }
        if (!\is_array($nodes)) {
            $nodes = [$nodes];
        }
        $nodeTraverser = new \ConfigTransformer2021082310\PhpParser\NodeTraverser();
        $callableNodeVisitor = $this->createNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
    private function createNodeVisitor(callable $callable) : \ConfigTransformer2021082310\PhpParser\NodeVisitor
    {
        return new class($callable) extends \ConfigTransformer2021082310\PhpParser\NodeVisitorAbstract
        {
            /**
             * @var callable
             */
            private $callable;
            public function __construct(callable $callable)
            {
                $this->callable = $callable;
            }
            /**
             * @return int|Node|null
             */
            public function enterNode(\ConfigTransformer2021082310\PhpParser\Node $node)
            {
                $originalNode = $node;
                $callable = $this->callable;
                /** @var int|Node|null $newNode */
                $newNode = $callable($node);
                if ($originalNode instanceof \ConfigTransformer2021082310\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer2021082310\PhpParser\Node\Expr) {
                    return new \ConfigTransformer2021082310\PhpParser\Node\Stmt\Expression($newNode);
                }
                return $newNode;
            }
        };
    }
}
