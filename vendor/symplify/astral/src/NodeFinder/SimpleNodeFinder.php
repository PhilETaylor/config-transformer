<?php

declare (strict_types=1);
namespace ConfigTransformer202106194\Symplify\Astral\NodeFinder;

use ConfigTransformer202106194\PhpParser\Node;
use ConfigTransformer202106194\PhpParser\NodeFinder;
use ConfigTransformer202106194\Symplify\Astral\ValueObject\AttributeKey;
use ConfigTransformer202106194\Symplify\PackageBuilder\Php\TypeChecker;
final class SimpleNodeFinder
{
    /**
     * @var \Symplify\PackageBuilder\Php\TypeChecker
     */
    private $typeChecker;
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(\ConfigTransformer202106194\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \ConfigTransformer202106194\PhpParser\NodeFinder $nodeFinder)
    {
        $this->typeChecker = $typeChecker;
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @template T of Node
     * @param class-string<T> $nodeClass
     * @return T[]
     */
    public function findByType(\ConfigTransformer202106194\PhpParser\Node $node, string $nodeClass) : array
    {
        return $this->nodeFinder->findInstanceOf($node, $nodeClass);
    }
    /**
     * @template T of Node
     * @param array<class-string<T>> $nodeClasses
     */
    public function hasByTypes(\ConfigTransformer202106194\PhpParser\Node $node, array $nodeClasses) : bool
    {
        foreach ($nodeClasses as $nodeClass) {
            $foundNodes = $this->findByType($node, $nodeClass);
            if ($foundNodes !== []) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @see https://phpstan.org/blog/generics-in-php-using-phpdocs for template
     *
     * @template T of Node
     * @param class-string<T> $nodeClass
     * @return T|null
     */
    public function findFirstParentByType(\ConfigTransformer202106194\PhpParser\Node $node, string $nodeClass) : ?\ConfigTransformer202106194\PhpParser\Node
    {
        $node = $node->getAttribute(\ConfigTransformer202106194\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        while ($node) {
            if (\is_a($node, $nodeClass, \true)) {
                return $node;
            }
            $node = $node->getAttribute(\ConfigTransformer202106194\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        }
        return null;
    }
    /**
     * @template T of Node
     * @param class-string<T>[] $nodeTypes
     * @return T|null
     */
    public function findFirstParentByTypes(\ConfigTransformer202106194\PhpParser\Node $node, array $nodeTypes) : ?\ConfigTransformer202106194\PhpParser\Node
    {
        $node = $node->getAttribute(\ConfigTransformer202106194\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        while ($node) {
            if ($this->typeChecker->isInstanceOf($node, $nodeTypes)) {
                return $node;
            }
            $node = $node->getAttribute(\ConfigTransformer202106194\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        }
        return null;
    }
}
