<?php

declare (strict_types=1);
namespace ConfigTransformer202106120\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory;

use ConfigTransformer202106120\PhpParser\BuilderHelpers;
use ConfigTransformer202106120\PhpParser\Node\Arg;
use ConfigTransformer202106120\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106120\PhpParser\Node\Scalar\String_;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202106120\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const TAG = 'tag';
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202106120\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202106120\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202106120\PhpParser\Node\Expr\MethodCall
    {
        /** @var mixed[] $yaml */
        if (\count($yaml) === 1 && \is_string($yaml[0])) {
            $string = new \ConfigTransformer202106120\PhpParser\Node\Scalar\String_($yaml[0]);
            return new \ConfigTransformer202106120\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, [new \ConfigTransformer202106120\PhpParser\Node\Arg($string)]);
        }
        foreach ($yaml as $singleValue) {
            $args = [];
            foreach ($singleValue as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new \ConfigTransformer202106120\PhpParser\Node\Arg(\ConfigTransformer202106120\PhpParser\BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($singleValue[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($singleValue);
            $args = \array_merge($args, $restArgs);
            $methodCall = new \ConfigTransformer202106120\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::TAGS;
    }
}
