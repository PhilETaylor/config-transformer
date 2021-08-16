<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108166\Symfony\Component\Config\Loader;

/**
 * Placeholder for a parameter.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ParamConfigurator
{
    private $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function __toString() : string
    {
        return '%' . $this->name . '%';
    }
}
