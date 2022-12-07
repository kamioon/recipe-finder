<?php

namespace App\Kitchen\Finder;

use App\Kitchen\Cabinet\ContainerInterface;
use App\Kitchen\Cabinet\IngredientQuantityInterface;
use App\Kitchen\Cabinet\Rules\QuantityException;
use App\Kitchen\Calculator\CalculatorInterface;
use App\Kitchen\Recipe\Recipe;
use App\Kitchen\Recipe\RecipeInterface;
use Measurements\Comparable;
use Measurements\Exceptions\MeasurementValueException;
use Measurements\Exceptions\UnitException;
use Measurements\Measurement;
use Measurements\Units\UnitVolume;
use Psr\Log\LoggerInterface;

class RecipeFinder implements FinderInterface
{
    private int $bestScore = 0;
    private ?ContainerInterface $bestContainer = null;

    public function __construct(
        private ContainerInterface           $container,
        private readonly CalculatorInterface $calculator,
        private readonly ?LoggerInterface    $logger = null
    )
    {
    }

    /**
     * @throws MeasurementValueException
     */
    public function find(): RecipeInterface
    {
        $this->adjustQuantity();
        return new Recipe($this->bestContainer, $this->bestScore);

    }

    /**
     * @throws MeasurementValueException
     */
    private function adjustQuantity()
    {

        $testQuantities = $this->generate_quantities($this->container->getCapacity()->value(), $this->container->getIngredientQuantities());
        foreach ($testQuantities as $testQuantity) {
            try {

                $this->container = $this->container->setIngredientQuantities(...$testQuantity);
                $score = $this->calculator->setContainer($this->container)->getScore();

                if ($this->logger) {
                    $this->logger->info("Container: " . $this->container->getName());
                    $this->logger->info("Score: " . $score);
                    $this->logger->info(json_encode($this->container));
                }

                if ($score > $this->bestScore) {
                    $this->bestScore = $score;
                    $this->bestContainer = clone $this->calculator->getContainer();
                }
            } catch (QuantityException $exception) {
                if ($this->logger) {
                    $this->logger->error($exception);
                }
            }
        }
    }


    /**
     * @throws MeasurementValueException
     */
    private function generate_quantities($maxQuantity, $Ingredients)
    {
        $ingredientCounts = count($Ingredients);

        if ($ingredientCounts === 1) {
            yield [current($Ingredients)->setQuantity(new Measurement($maxQuantity, current($Ingredients)->getQuantity()->unit()))];
            return;
        }

        $result = array_shift($Ingredients);

        for ($value = $maxQuantity; 0 <= $value; $value--) {
            foreach ($this->generate_quantities(
                $maxQuantity - $value,
                $Ingredients
            ) as $options) {
                yield [$result->setQuantity(new Measurement($value, current($Ingredients)->getQuantity()->unit())), ...$options];
            }
        }
    }
}