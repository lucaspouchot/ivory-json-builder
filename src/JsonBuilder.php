<?php

/*
 * This file is part of the Ivory Json Builder package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\JsonBuilder;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class JsonBuilder
{
    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * @var array
     */
    private $values;

    /**
     * @var array
     */
    private $escapes;

    /**
     * @var int
     */
    private $jsonEncodeOptions;


    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->accessor = $propertyAccessor ?: new PropertyAccessor();

        $this->reset();
    }

    public function getJsonEncodeOptions(): int
    {
        return $this->jsonEncodeOptions;
    }

    public function setJsonEncodeOptions(int $jsonEncodeOptions): JsonBuilder
    {
        $this->jsonEncodeOptions = $jsonEncodeOptions;

        return $this;
    }

    public function hasValues(): bool
    {
        return !empty($this->values);
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values, string $pathPrefix = null): JsonBuilder
    {
        foreach ($values as $key => $value) {
            $path = sprintf('%s[%s]', $pathPrefix, $key);

            if (is_array($value) && !empty($value)) {
                $this->setValues($value, $path);
            } else {
                $this->setValue($path, $value);
            }
        }

        return $this;
    }

    /**
     * @param mixed $value
     */
    public function setValue(string $path, $value, bool $escapeValue = true): JsonBuilder
    {
        if (!$escapeValue) {
            $placeholder = uniqid('ivory', true);
            $this->escapes[sprintf('"%s"', $placeholder)] = $value;

            $value = $placeholder;
        }

        $this->values[$path] = $value;

        return $this;
    }

    public function removeValue(string $path): JsonBuilder
    {
        unset($this->values[$path]);
        unset($this->escapes[$path]);

        return $this;
    }

    public function reset(): JsonBuilder
    {
        $this->values = [];
        $this->escapes = [];
        $this->jsonEncodeOptions = 0;

        return $this;
    }

    public function build(): string
    {
        $json = [];

        foreach ($this->values as $path => $value) {
            $this->accessor->setValue($json, $path, $value);
        }

        return str_replace(
            array_keys($this->escapes),
            array_values($this->escapes),
            json_encode($json, $this->jsonEncodeOptions)
        );
    }
}
