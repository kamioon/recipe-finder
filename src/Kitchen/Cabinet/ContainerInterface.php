<?php

namespace App\Kitchen\Cabinet;

use App\Kitchen\Cabinet\Rules\RuleInterface;
use Measurements\Comparable;

interface ContainerInterface extends RuleInterface
{

    public function getCapacity(): Comparable;

    public function getVolume(): Comparable;

    public function getName(): string;

    public function getIngredientQuantities(): array;

    public function addIngredientQuantity(IngredientQuantity $ingredientQuantity): self;

    public function setIngredientQuantities(IngredientQuantity ...$ingredientQuantities): self;

}