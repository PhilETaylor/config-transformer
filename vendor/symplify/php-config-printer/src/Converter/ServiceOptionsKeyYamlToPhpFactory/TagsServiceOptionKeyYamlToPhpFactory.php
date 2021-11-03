<?php

declare (strict_types=1);
namespace ConfigTransformer2021110310\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory;

use ConfigTransformer2021110310\PhpParser\BuilderHelpers;
use ConfigTransformer2021110310\PhpParser\Node\Arg;
use ConfigTransformer2021110310\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021110310\PhpParser\Node\Scalar\String_;
use ConfigTransformer2021110310\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021110310\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021110310\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021110310\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const TAG = 'tag';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2021110310\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yamlLines, $values, $methodCall) : \ConfigTransformer2021110310\PhpParser\Node\Expr\MethodCall
    {
        /** @var mixed[] $yamlLines */
        if (\count($yamlLines) === 1 && \is_string($yamlLines[0])) {
            $string = new \ConfigTransformer2021110310\PhpParser\Node\Scalar\String_($yamlLines[0]);
            return new \ConfigTransformer2021110310\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, [new \ConfigTransformer2021110310\PhpParser\Node\Arg($string)]);
        }
        foreach ($yamlLines as $yamlLine) {
            $args = [];
            foreach ($yamlLine as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new \ConfigTransformer2021110310\PhpParser\Node\Arg(\ConfigTransformer2021110310\PhpParser\BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($yamlLine[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($yamlLine);
            $args = \array_merge($args, $restArgs);
            $methodCall = new \ConfigTransformer2021110310\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer2021110310\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::TAGS;
    }
}
