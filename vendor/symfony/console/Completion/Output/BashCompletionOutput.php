<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112319\Symfony\Component\Console\Completion\Output;

use ConfigTransformer202112319\Symfony\Component\Console\Completion\CompletionSuggestions;
use ConfigTransformer202112319\Symfony\Component\Console\Output\OutputInterface;
/**
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class BashCompletionOutput implements \ConfigTransformer202112319\Symfony\Component\Console\Completion\Output\CompletionOutputInterface
{
    public function write(\ConfigTransformer202112319\Symfony\Component\Console\Completion\CompletionSuggestions $suggestions, \ConfigTransformer202112319\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $values = $suggestions->getValueSuggestions();
        foreach ($suggestions->getOptionSuggestions() as $option) {
            $values[] = '--' . $option->getName();
        }
        $output->writeln(\implode("\n", $values));
    }
}
