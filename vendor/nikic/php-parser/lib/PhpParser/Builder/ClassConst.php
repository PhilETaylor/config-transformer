<?php

declare (strict_types=1);
namespace ConfigTransformer2021110310\PhpParser\Builder;

use ConfigTransformer2021110310\PhpParser;
use ConfigTransformer2021110310\PhpParser\BuilderHelpers;
use ConfigTransformer2021110310\PhpParser\Node;
use ConfigTransformer2021110310\PhpParser\Node\Const_;
use ConfigTransformer2021110310\PhpParser\Node\Identifier;
use ConfigTransformer2021110310\PhpParser\Node\Stmt;
class ClassConst implements \ConfigTransformer2021110310\PhpParser\Builder
{
    protected $flags = 0;
    protected $attributes = [];
    protected $constants = [];
    /** @var Node\AttributeGroup[] */
    protected $attributeGroups = [];
    /**
     * Creates a class constant builder
     *
     * @param string|Identifier                          $name  Name
     * @param Node\Expr|bool|null|int|float|string|array $value Value
     */
    public function __construct($name, $value)
    {
        $this->constants = [new \ConfigTransformer2021110310\PhpParser\Node\Const_($name, \ConfigTransformer2021110310\PhpParser\BuilderHelpers::normalizeValue($value))];
    }
    /**
     * Add another constant to const group
     *
     * @param string|Identifier                          $name  Name
     * @param Node\Expr|bool|null|int|float|string|array $value Value
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addConst($name, $value)
    {
        $this->constants[] = new \ConfigTransformer2021110310\PhpParser\Node\Const_($name, \ConfigTransformer2021110310\PhpParser\BuilderHelpers::normalizeValue($value));
        return $this;
    }
    /**
     * Makes the constant public.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePublic()
    {
        $this->flags = \ConfigTransformer2021110310\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer2021110310\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
        return $this;
    }
    /**
     * Makes the constant protected.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeProtected()
    {
        $this->flags = \ConfigTransformer2021110310\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer2021110310\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
        return $this;
    }
    /**
     * Makes the constant private.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePrivate()
    {
        $this->flags = \ConfigTransformer2021110310\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer2021110310\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
        return $this;
    }
    /**
     * Makes the constant final.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeFinal()
    {
        $this->flags = \ConfigTransformer2021110310\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer2021110310\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL);
        return $this;
    }
    /**
     * Sets doc comment for the constant.
     *
     * @param PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment)
    {
        $this->attributes = ['comments' => [\ConfigTransformer2021110310\PhpParser\BuilderHelpers::normalizeDocComment($docComment)]];
        return $this;
    }
    /**
     * Adds an attribute group.
     *
     * @param Node\Attribute|Node\AttributeGroup $attribute
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addAttribute($attribute)
    {
        $this->attributeGroups[] = \ConfigTransformer2021110310\PhpParser\BuilderHelpers::normalizeAttribute($attribute);
        return $this;
    }
    /**
     * Returns the built class node.
     *
     * @return Stmt\ClassConst The built constant node
     */
    public function getNode() : \ConfigTransformer2021110310\PhpParser\Node
    {
        return new \ConfigTransformer2021110310\PhpParser\Node\Stmt\ClassConst($this->constants, $this->flags, $this->attributes, $this->attributeGroups);
    }
}
