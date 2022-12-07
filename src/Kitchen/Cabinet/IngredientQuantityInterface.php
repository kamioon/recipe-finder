<?php

namespace App\Kitchen\Cabinet;

use App\Kitchen\Cabinet\Rules\RuleInterface;
use Measurements\Comparable;

interface IngredientQuantityInterface extends RuleInterface
{
    public function getIngredient(): IngredientInterface;

    public function getQuantity(): Comparable;

    public function setQuantity(Comparable $quantity): self;
}