<?php

namespace App\Kitchen\Cabinet\Rules;

use Measurements\Exceptions\MeasurementValueException;
use Measurements\Measurement;
use Measurements\Units\UnitVolume;

class IngredientQuantityRule implements RuleInterface
{
    const MAX_VALUE = 100;

    /**
     * @throws MeasurementValueException
     * @throws QuantityException
     */
    public function passes($object): bool
    {
        $maxQuantity = new Measurement(self::MAX_VALUE, UnitVolume::teaspoons());
        if ($object->isGreaterThan($maxQuantity)) {
            throw new QuantityException("Quantity should not be more than " . $maxQuantity->toString());
        }
        return true;
    }
}