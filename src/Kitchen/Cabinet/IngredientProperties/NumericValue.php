<?php

namespace App\Kitchen\Cabinet\IngredientProperties;

use JsonSerializable;

class NumericValue implements JsonSerializable, PropertyInterface
{
    public static string $name;

    public function __construct(public readonly ?int $value = null)
    {
    }

    public function jsonSerialize(): ?int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function getName(): string
    {
        return static::$name;
    }

    public function getValue(): int|null
    {
        return $this->value;
    }
}
