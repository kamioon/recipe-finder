<?php

declare(strict_types=1);
namespace App\Kitchen\Recipe;

use App\Kitchen\Cabinet\ContainerInterface;
use JsonSerializable;

final class Recipe implements RecipeInterface, JsonSerializable
{
    public function __construct(public readonly ContainerInterface $container, public readonly int $score)
    {
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getIngredientQuantities(): array
    {
        return $this->container->getIngredientQuantities();
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function jsonSerialize(): array
    {
        return [
            "ingredient_quantities" => $this->container->getIngredientQuantities(),
            "score" => $this->score
        ];
    }
}