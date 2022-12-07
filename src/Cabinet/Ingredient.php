<?php
declare(strict_types=1);

final class Ingredient implements IngredientInterface
{
    /**
     * @param string $title
     * @param int $capacity
     * @param int $durability
     * @param int $flavour
     * @param int $texture
     * @param int $calories
     */
    public function __construct(
        private readonly string $title,
        private readonly int    $capacity,
        private readonly int    $durability,
        private readonly int    $flavour,
        private readonly int    $texture,
        private readonly int    $calories,
    )
    {

    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getDurability(): int
    {
        return $this->durability;
    }

    public function getFlavor(): int
    {
        return $this->flavour;
    }

    public function getTexture(): int
    {
        return $this->texture;
    }

    public function getCalories(): int
    {
        return $this->calories;
    }
}