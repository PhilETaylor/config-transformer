<?php

declare (strict_types=1);
namespace ConfigTransformer202109187\Symplify\EasyTesting\ValueObject;

final class SplitLine
{
    /**
     * @see https://regex101.com/r/8fuULy/1
     * @var string
     */
    public const SPLIT_LINE_REGEX = "#\\-\\-\\-\\-\\-\r?\n#";
}
