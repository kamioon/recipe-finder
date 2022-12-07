<?php

namespace App\Kitchen\Cabinet;

use App\Kitchen\Cabinet\Rules\BowlQuantityRule;
use JsonSerializable;
use Measurements\Comparable;
use Measurements\Exceptions\MeasurementValueException;
use Measurements\Exceptions\UnitException;
use Measurements\Measurement;

class Bowl extends BowlQuantityRule implements ContainerInterface, JsonSerializable
{
    const NAME = "Glass Bowl";
    private array $ingredientQuantities;

    public function __construct(private readonly Comparable $capacity, IngredientQuantity ...$ingredients)
    {
        $this->ingredientQuantities = $ingredients;
        $this->passes($this);
    }

    public function addIngredientQuantity(IngredientQuantity $ingredientQuantity): self
    {
        $this->ingredientQuantities[] = $ingredientQuantity;
        return $this;
    }


    /**
     * @throws MeasurementValueException
     */public function setIngredientQuantities(IngredientQuantity ...$ingredients): self
    {
        $this->ingredientQuantities = $ingredients;
        $this->passes($this);
        return $this;
    }

    /**
     */
    public function getCapacity(): Comparable
    {
        return $this->capacity;
    }

    /**
     * @throws UnitException
     * @throws MeasurementValueException
     */
    public function getVolume(): Comparable
    {
        $volume = new Measurement(0, $this->capacity->unit());
        foreach ($this->getIngredientQuantities() as $ingredientQuantity) {
            $volume = $volume->add($ingredientQuantity->getQuantity());
        }
        return $volume;
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function getIngredientQuantities(): array
    {
        return $this->ingredientQuantities;
    }

    public function jsonSerialize(): mixed
    {
        return array(
            "name" => $this->getName(),
            "ingredient_quantity" => $this->ingredientQuantities,
            "capacity" => $this->capacity->toString(),
            "volume" => $this->getVolume()->toString(),
        );
    }
}