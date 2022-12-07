<?php

namespace App\Kitchen\Cabinet\IngredientProperties;

interface PropertyInterface
{
    public function __toString();

    public static function getName(): string;

    public function getValue(): mixed;
}