<?php

namespace App\Kitchen\Calculator;

use App\Kitchen\Cabinet\IngredientQuantity;

class PropertyCalculator
{
    public static function calculate(IngredientQuantity $ingredientQuantity, string $property): int
    {
        $propertyValue = $ingredientQuantity->getIngredient()->getProperties()[$property]->getValue();
        $quantityValue = (int)$ingredientQuantity->getQuantity()->value();
        $result = $quantityValue * $propertyValue;
        return intval($result);
    }


}