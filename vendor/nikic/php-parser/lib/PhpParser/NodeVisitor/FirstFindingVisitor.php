<?php

declare (strict_types=1);
namespace ConfigTransformer2021090210\PhpParser\NodeVisitor;

use ConfigTransformer2021090210\PhpParser\Node;
use ConfigTransformer2021090210\PhpParser\NodeTraverser;
use ConfigTransformer2021090210\PhpParser\NodeVisitorAbstract;
/**
 * This visitor can be used to find the first node satisfying some criterion determined by
 * a filter callback.
 */
class FirstFindingVisitor extends \ConfigTransformer2021090210\PhpParser\NodeVisitorAbstract
{
    /** @var callable Filter callback */
    protected $filterCallback;
    /** @var null|Node Found node */
    protected $foundNode;
    public function __construct(callable $filterCallback)
    {
        $this->filterCallback = $filterCallback;
    }
    /**
     * Get found node satisfying the filter callback.
     *
     * Returns null if no node satisfies the filter callback.
     *
     * @return null|Node Found node (or null if not found)
     */
    public function getFoundNode()
    {
        return $this->foundNode;
    }
    /**
     * @param mixed[] $nodes
     */
    public function beforeTraverse($nodes)
    {
        $this->foundNode = null;
        return null;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function enterNode($node)
    {
        $filterCallback = $this->filterCallback;
        if ($filterCallback($node)) {
            $this->foundNode = $node;
            return \ConfigTransformer2021090210\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        }
        return null;
    }
}
