<?php

namespace App\Kitchen\Cabinet;


use App\Kitchen\Cabinet\Rules\IngredientQuantityRule;
use App\Kitchen\Cabinet\Rules\QuantityException;
use JsonSerializable;
use Measurements\Comparable;
use Measurements\Exceptions\MeasurementValueException;

final class IngredientQuantity extends IngredientQuantityRule implements IngredientQuantityInterface, jsonSerializable
{

    /**
     * @throws MeasurementValueException
     * @throws QuantityException
     */
    public function __construct(private readonly IngredientInterface $ingredient, private Comparable $quantity)
    {
        $this->passes($this->quantity);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "ingredient" => $this->getIngredient(),
            "quantity" => $this->getQuantity()->toString(),
        ];
    }

    /**
     * @return IngredientInterface
     */
    public function getIngredient(): IngredientInterface
    {
        return $this->ingredient;
    }

    public function getQuantity(): Comparable
    {
        return $this->quantity;
    }

    public function setQuantity(Comparable $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

}