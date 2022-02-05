<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202202050\Symfony\Component\Config\Definition;

use ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\UnsetKeyException;
/**
 * Represents an Array node in the config tree.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ArrayNode extends \ConfigTransformer202202050\Symfony\Component\Config\Definition\BaseNode implements \ConfigTransformer202202050\Symfony\Component\Config\Definition\PrototypeNodeInterface
{
    protected $xmlRemappings = [];
    protected $children = [];
    protected $allowFalse = \false;
    protected $allowNewKeys = \true;
    protected $addIfNotSet = \false;
    protected $performDeepMerging = \true;
    protected $ignoreExtraKeys = \false;
    protected $removeExtraKeys = \true;
    protected $normalizeKeys = \true;
    public function setNormalizeKeys(bool $normalizeKeys)
    {
        $this->normalizeKeys = $normalizeKeys;
    }
    /**
     * {@inheritdoc}
     *
     * Namely, you mostly have foo_bar in YAML while you have foo-bar in XML.
     * After running this method, all keys are normalized to foo_bar.
     *
     * If you have a mixed key like foo-bar_moo, it will not be altered.
     * The key will also not be altered if the target key already exists.
     * @param mixed $value
     * @return mixed
     */
    protected function preNormalize($value)
    {
        if (!$this->normalizeKeys || !\is_array($value)) {
            return $value;
        }
        $normalized = [];
        foreach ($value as $k => $v) {
            if (\strpos($k, '-') !== \false && \strpos($k, '_') === \false && !\array_key_exists($normalizedKey = \str_replace('-', '_', $k), $value)) {
                $normalized[$normalizedKey] = $v;
            } else {
                $normalized[$k] = $v;
            }
        }
        return $normalized;
    }
    /**
     * Retrieves the children of this node.
     *
     * @return array<string, NodeInterface>
     */
    public function getChildren() : array
    {
        return $this->children;
    }
    /**
     * Sets the xml remappings that should be performed.
     *
     * @param array $remappings An array of the form [[string, string]]
     */
    public function setXmlRemappings(array $remappings)
    {
        $this->xmlRemappings = $remappings;
    }
    /**
     * Gets the xml remappings that should be performed.
     *
     * @return array an array of the form [[string, string]]
     */
    public function getXmlRemappings() : array
    {
        return $this->xmlRemappings;
    }
    /**
     * Sets whether to add default values for this array if it has not been
     * defined in any of the configuration files.
     */
    public function setAddIfNotSet(bool $boolean)
    {
        $this->addIfNotSet = $boolean;
    }
    /**
     * Sets whether false is allowed as value indicating that the array should be unset.
     */
    public function setAllowFalse(bool $allow)
    {
        $this->allowFalse = $allow;
    }
    /**
     * Sets whether new keys can be defined in subsequent configurations.
     */
    public function setAllowNewKeys(bool $allow)
    {
        $this->allowNewKeys = $allow;
    }
    /**
     * Sets if deep merging should occur.
     */
    public function setPerformDeepMerging(bool $boolean)
    {
        $this->performDeepMerging = $boolean;
    }
    /**
     * Whether extra keys should just be ignored without an exception.
     *
     * @param bool $boolean To allow extra keys
     * @param bool $remove  To remove extra keys
     */
    public function setIgnoreExtraKeys(bool $boolean, bool $remove = \true)
    {
        $this->ignoreExtraKeys = $boolean;
        $this->removeExtraKeys = $this->ignoreExtraKeys && $remove;
    }
    /**
     * Returns true when extra keys should be ignored without an exception.
     */
    public function shouldIgnoreExtraKeys() : bool
    {
        return $this->ignoreExtraKeys;
    }
    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    /**
     * {@inheritdoc}
     */
    public function hasDefaultValue() : bool
    {
        return $this->addIfNotSet;
    }
    /**
     * {@inheritdoc}
     * @return mixed
     */
    public function getDefaultValue()
    {
        if (!$this->hasDefaultValue()) {
            throw new \RuntimeException(\sprintf('The node at path "%s" has no default value.', $this->getPath()));
        }
        $defaults = [];
        foreach ($this->children as $name => $child) {
            if ($child->hasDefaultValue()) {
                $defaults[$name] = $child->getDefaultValue();
            }
        }
        return $defaults;
    }
    /**
     * Adds a child node.
     *
     * @throws \InvalidArgumentException when the child node has no name
     * @throws \InvalidArgumentException when the child node's name is not unique
     */
    public function addChild(\ConfigTransformer202202050\Symfony\Component\Config\Definition\NodeInterface $node)
    {
        $name = $node->getName();
        if ('' === $name) {
            throw new \InvalidArgumentException('Child nodes must be named.');
        }
        if (isset($this->children[$name])) {
            throw new \InvalidArgumentException(\sprintf('A child node named "%s" already exists.', $name));
        }
        $this->children[$name] = $node;
    }
    /**
     * {@inheritdoc}
     *
     * @throws UnsetKeyException
     * @throws InvalidConfigurationException if the node doesn't have enough children
     * @param mixed $value
     * @return mixed
     */
    protected function finalizeValue($value)
    {
        if (\false === $value) {
            throw new \ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\UnsetKeyException(\sprintf('Unsetting key for path "%s", value: %s.', $this->getPath(), \json_encode($value)));
        }
        foreach ($this->children as $name => $child) {
            if (!\array_key_exists($name, $value)) {
                if ($child->isRequired()) {
                    $message = \sprintf('The child config "%s" under "%s" must be configured', $name, $this->getPath());
                    if ($child->getInfo()) {
                        $message .= \sprintf(': %s', $child->getInfo());
                    } else {
                        $message .= '.';
                    }
                    $ex = new \ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException($message);
                    $ex->setPath($this->getPath());
                    throw $ex;
                }
                if ($child->hasDefaultValue()) {
                    $value[$name] = $child->getDefaultValue();
                }
                continue;
            }
            if ($child->isDeprecated()) {
                $deprecation = $child->getDeprecation($name, $this->getPath());
                trigger_deprecation($deprecation['package'], $deprecation['version'], $deprecation['message']);
            }
            try {
                $value[$name] = $child->finalize($value[$name]);
            } catch (\ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\UnsetKeyException $e) {
                unset($value[$name]);
            }
        }
        return $value;
    }
    /**
     * {@inheritdoc}
     * @param mixed $value
     */
    protected function validateType($value)
    {
        if (!\is_array($value) && (!$this->allowFalse || \false !== $value)) {
            $ex = new \ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\InvalidTypeException(\sprintf('Invalid type for path "%s". Expected "array", but got "%s"', $this->getPath(), \get_debug_type($value)));
            if ($hint = $this->getInfo()) {
                $ex->addHint($hint);
            }
            $ex->setPath($this->getPath());
            throw $ex;
        }
    }
    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigurationException
     * @param mixed $value
     * @return mixed
     */
    protected function normalizeValue($value)
    {
        if (\false === $value) {
            return $value;
        }
        $value = $this->remapXml($value);
        $normalized = [];
        foreach ($value as $name => $val) {
            if (isset($this->children[$name])) {
                try {
                    $normalized[$name] = $this->children[$name]->normalize($val);
                } catch (\ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\UnsetKeyException $e) {
                }
                unset($value[$name]);
            } elseif (!$this->removeExtraKeys) {
                $normalized[$name] = $val;
            }
        }
        // if extra fields are present, throw exception
        if (\count($value) && !$this->ignoreExtraKeys) {
            $proposals = \array_keys($this->children);
            \sort($proposals);
            $guesses = [];
            foreach (\array_keys($value) as $subject) {
                $minScore = \INF;
                foreach ($proposals as $proposal) {
                    $distance = \levenshtein($subject, $proposal);
                    if ($distance <= $minScore && $distance < 3) {
                        $guesses[$proposal] = $distance;
                        $minScore = $distance;
                    }
                }
            }
            $msg = \sprintf('Unrecognized option%s "%s" under "%s"', 1 === \count($value) ? '' : 's', \implode(', ', \array_keys($value)), $this->getPath());
            if (\count($guesses)) {
                \asort($guesses);
                $msg .= \sprintf('. Did you mean "%s"?', \implode('", "', \array_keys($guesses)));
            } else {
                $msg .= \sprintf('. Available option%s %s "%s".', 1 === \count($proposals) ? '' : 's', 1 === \count($proposals) ? 'is' : 'are', \implode('", "', $proposals));
            }
            $ex = new \ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException($msg);
            $ex->setPath($this->getPath());
            throw $ex;
        }
        return $normalized;
    }
    /**
     * Remaps multiple singular values to a single plural value.
     */
    protected function remapXml(array $value) : array
    {
        foreach ($this->xmlRemappings as [$singular, $plural]) {
            if (!isset($value[$singular])) {
                continue;
            }
            $value[$plural] = \ConfigTransformer202202050\Symfony\Component\Config\Definition\Processor::normalizeConfig($value, $singular, $plural);
            unset($value[$singular]);
        }
        return $value;
    }
    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigurationException
     * @throws \RuntimeException
     * @param mixed $leftSide
     * @param mixed $rightSide
     * @return mixed
     */
    protected function mergeValues($leftSide, $rightSide)
    {
        if (\false === $rightSide) {
            // if this is still false after the last config has been merged the
            // finalization pass will take care of removing this key entirely
            return \false;
        }
        if (\false === $leftSide || !$this->performDeepMerging) {
            return $rightSide;
        }
        foreach ($rightSide as $k => $v) {
            // no conflict
            if (!\array_key_exists($k, $leftSide)) {
                if (!$this->allowNewKeys) {
                    $ex = new \ConfigTransformer202202050\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException(\sprintf('You are not allowed to define new elements for path "%s". Please define all elements for this path in one config file. If you are trying to overwrite an element, make sure you redefine it with the same name.', $this->getPath()));
                    $ex->setPath($this->getPath());
                    throw $ex;
                }
                $leftSide[$k] = $v;
                continue;
            }
            if (!isset($this->children[$k])) {
                if (!$this->ignoreExtraKeys || $this->removeExtraKeys) {
                    throw new \RuntimeException('merge() expects a normalized config array.');
                }
                $leftSide[$k] = $v;
                continue;
            }
            $leftSide[$k] = $this->children[$k]->merge($leftSide[$k], $v);
        }
        return $leftSide;
    }
    /**
     * {@inheritdoc}
     */
    protected function allowPlaceholders() : bool
    {
        return \false;
    }
}
