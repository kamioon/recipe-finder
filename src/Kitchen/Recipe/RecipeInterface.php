<?php

namespace App\Kitchen\Recipe;

use App\Kitchen\Cabinet\ContainerInterface;

interface RecipeInterface
{
    public function getContainer(): ContainerInterface;

    public function getIngredientQuantities(): array;

    public function getScore(): int;


}