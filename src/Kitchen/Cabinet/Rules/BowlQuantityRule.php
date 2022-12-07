<?php

namespace App\Kitchen\Cabinet\Rules;

use App\Kitchen\Cabinet\Bowl;
use Exception;
use Measurements\Exceptions\MeasurementValueException;

class BowlQuantityRule implements RuleInterface
{

    /**
     * @throws MeasurementValueException
     * @throws Exception
     * @var Bowl $object
     */
    public function passes($object): bool
    {
        $maxQuantity = $object->getCapacity();
        $totalQuantity = $object->getVolume();

        if ($totalQuantity->isGreaterThan($maxQuantity)) {
            throw new QuantityException("Recipe Quantity should not be more than " . $maxQuantity->toString());
        }

//        if ($totalQuantity->isLessThan($maxQuantity)) {
//            throw new QuantityException("Recipe Quantity should not be less than " . $maxQuantity->toString());
//        }

        return true;
    }
}