<?php
declare(strict_types=1);

interface IngredientInterface
{
    public function getTitle(): string;

    public function getCapacity(): int;

    public function getDurability(): int;

    public function getFlavor(): int;

    public function getTexture(): int;

    public function getCalories(): int;
}