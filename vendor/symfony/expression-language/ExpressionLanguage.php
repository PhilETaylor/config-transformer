<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202206011\Symfony\Component\ExpressionLanguage;

use ConfigTransformer202206011\Psr\Cache\CacheItemPoolInterface;
use ConfigTransformer202206011\Symfony\Component\Cache\Adapter\ArrayAdapter;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ParsedExpression::class);
/**
 * Allows to compile and evaluate expressions written in your own DSL.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ExpressionLanguage
{
    private $cache;
    private $lexer;
    private $parser;
    private $compiler;
    /**
     * @var mixed[]
     */
    protected $functions = [];
    /**
     * @param ExpressionFunctionProviderInterface[] $providers
     */
    public function __construct(\ConfigTransformer202206011\Psr\Cache\CacheItemPoolInterface $cache = null, array $providers = [])
    {
        $this->cache = $cache ?? new \ConfigTransformer202206011\Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->registerFunctions();
        foreach ($providers as $provider) {
            $this->registerProvider($provider);
        }
    }
    /**
     * Compiles an expression source code.
     * @param \Symfony\Component\ExpressionLanguage\Expression|string $expression
     */
    public function compile($expression, array $names = []) : string
    {
        return $this->getCompiler()->compile($this->parse($expression, $names)->getNodes())->getSource();
    }
    /**
     * Evaluate an expression.
     * @param \Symfony\Component\ExpressionLanguage\Expression|string $expression
     * @return mixed
     */
    public function evaluate($expression, array $values = [])
    {
        return $this->parse($expression, \array_keys($values))->getNodes()->evaluate($this->functions, $values);
    }
    /**
     * Parses an expression.
     * @param \Symfony\Component\ExpressionLanguage\Expression|string $expression
     */
    public function parse($expression, array $names) : \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ParsedExpression
    {
        if ($expression instanceof \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ParsedExpression) {
            return $expression;
        }
        \asort($names);
        $cacheKeyItems = [];
        foreach ($names as $nameKey => $name) {
            $cacheKeyItems[] = \is_int($nameKey) ? $name : $nameKey . ':' . $name;
        }
        $cacheItem = $this->cache->getItem(\rawurlencode($expression . '//' . \implode('|', $cacheKeyItems)));
        if (null === ($parsedExpression = $cacheItem->get())) {
            $nodes = $this->getParser()->parse($this->getLexer()->tokenize((string) $expression), $names);
            $parsedExpression = new \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ParsedExpression((string) $expression, $nodes);
            $cacheItem->set($parsedExpression);
            $this->cache->save($cacheItem);
        }
        return $parsedExpression;
    }
    /**
     * Validates the syntax of an expression.
     *
     * @param array|null $names The list of acceptable variable names in the expression, or null to accept any names
     *
     * @throws SyntaxError When the passed expression is invalid
     * @param \Symfony\Component\ExpressionLanguage\Expression|string $expression
     */
    public function lint($expression, ?array $names) : void
    {
        if ($expression instanceof \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ParsedExpression) {
            return;
        }
        $this->getParser()->lint($this->getLexer()->tokenize((string) $expression), $names);
    }
    /**
     * Registers a function.
     *
     * @param callable $compiler  A callable able to compile the function
     * @param callable $evaluator A callable able to evaluate the function
     *
     * @throws \LogicException when registering a function after calling evaluate(), compile() or parse()
     *
     * @see ExpressionFunction
     */
    public function register(string $name, callable $compiler, callable $evaluator)
    {
        if (isset($this->parser)) {
            throw new \LogicException('Registering functions after calling evaluate(), compile() or parse() is not supported.');
        }
        $this->functions[$name] = ['compiler' => $compiler, 'evaluator' => $evaluator];
    }
    public function addFunction(\ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ExpressionFunction $function)
    {
        $this->register($function->getName(), $function->getCompiler(), $function->getEvaluator());
    }
    public function registerProvider(\ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface $provider)
    {
        foreach ($provider->getFunctions() as $function) {
            $this->addFunction($function);
        }
    }
    protected function registerFunctions()
    {
        $this->addFunction(\ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('constant'));
    }
    private function getLexer() : \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\Lexer
    {
        return $this->lexer = $this->lexer ?? new \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\Lexer();
    }
    private function getParser() : \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\Parser
    {
        return $this->parser = $this->parser ?? new \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\Parser($this->functions);
    }
    private function getCompiler() : \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\Compiler
    {
        $this->compiler = $this->compiler ?? new \ConfigTransformer202206011\Symfony\Component\ExpressionLanguage\Compiler($this->functions);
        return $this->compiler->reset();
    }
}
