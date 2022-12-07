<?php
declare(strict_types=1);

namespace App\Kitchen\Cabinet;

use App\Kitchen\Cabinet\IngredientProperties\PropertyInterface;

interface IngredientInterface
{
    public function getName(): PropertyInterface;

    public function getCapacity(): PropertyInterface;

    public function getDurability(): PropertyInterface;

    public function getFlavor(): PropertyInterface;

    public function getTexture(): PropertyInterface;

    public function getCalories(): PropertyInterface;

    public function getProperties(): array;
}