<?php

namespace App\Kitchen\Cabinet\IngredientProperties;

use JsonSerializable;

abstract class StringValue implements JsonSerializable, PropertyInterface
{

    public static string $name;

    public function __construct(public readonly ?string $value = null)
    {
    }

    public function jsonSerialize(): ?string
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

    public function getValue(): string|null
    {
        return $this->value;
    }
}
