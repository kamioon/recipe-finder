<?php
declare(strict_types=1);

namespace App\Kitchen\Cabinet;

use App\Kitchen\Cabinet\IngredientProperties\PropertyInterface;
use JsonSerializable;

final class Ingredient implements IngredientInterface, JsonSerializable
{

    /**
     * @param PropertyInterface $name
     * @param PropertyInterface $capacity
     * @param PropertyInterface $durability
     * @param PropertyInterface $flavor
     * @param PropertyInterface $texture
     * @param PropertyInterface $calories
     */
    public function __construct(
        private readonly PropertyInterface $name,
        private readonly PropertyInterface $capacity,
        private readonly PropertyInterface $durability,
        private readonly PropertyInterface $flavor,
        private readonly PropertyInterface $texture,
        private readonly PropertyInterface $calories,
    )
    {

    }

    public function getName(): PropertyInterface
    {
        return $this->name;
    }

    public function getCapacity(): PropertyInterface
    {
        return $this->capacity;
    }

    public function getDurability(): PropertyInterface
    {
        return $this->durability;
    }

    public function getFlavor(): PropertyInterface
    {
        return $this->flavor;
    }

    public function getTexture(): PropertyInterface
    {
        return $this->texture;
    }

    public function getCalories(): PropertyInterface
    {
        return $this->calories;
    }

    public function jsonSerialize(): array
    {
        return [
            "name" => $this->name->getValue(),
            "capacity" => $this->capacity->getValue(),
            "durability" => $this->durability->getValue(),
            "flavor" => $this->flavor->getValue(),
            "texture" => $this->texture->getValue(),
            "calories" => $this->calories->getValue(),
        ];
    }

    public function getProperties(): array
    {
        return [
            "capacity" => $this->capacity,
            "durability" => $this->durability,
            "flavor" => $this->flavor,
            "texture" => $this->texture,
            "calories" => $this->calories,
        ];

    }

}