<?php

namespace App\Kitchen\Calculator;

use App\Kitchen\Cabinet\ContainerInterface;
use Measurements\Comparable;
use Measurements\Exceptions\UnitException;

final class TasteCalculator implements CalculatorInterface
{
    private const CALCULATION_MIN_SCORE = 0;
    private const CALCULATION_PROPERTIES = [
        "capacity",
        "durability",
        "flavor",
        "texture"
    ];

    public function __construct(public ?ContainerInterface $container = null)
    {
    }

    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;
        return $this;
    }

    public function getPropertySum(string $property): int
    {
        $sum = 0;
        foreach ($this->container->getIngredientQuantities() as $ingredientQuantity) {
            $sum += $ingredientQuantity->getIngredient()->getProperties()[$property]->getValue();
        }
        return $sum;

    }

    public function getPropertyScore(string $property): int
    {
        $total = 0;
        foreach ($this->container->getIngredientQuantities() as $ingredientQuantity) {
            $total += PropertyCalculator::calculate($ingredientQuantity, $property);
        }

        if ($total < self::CALCULATION_MIN_SCORE) $total = 0;

        return $total;
    }

    public function getScore(): int
    {
        $scores = [];
        foreach (self::CALCULATION_PROPERTIES as $property) {
            $scores[$property] = $this->getPropertyScore($property);
        }
        return array_product($scores);
    }

    public function getCalculationProperties(): array
    {
        return self::CALCULATION_PROPERTIES;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}