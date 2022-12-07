<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Kitchen\Cabinet\Bowl;
use App\Kitchen\Cabinet\Ingredient;
use App\Kitchen\Cabinet\IngredientProperties\Calories;
use App\Kitchen\Cabinet\IngredientProperties\Capacity;
use App\Kitchen\Cabinet\IngredientProperties\Durability;
use App\Kitchen\Cabinet\IngredientProperties\Flavor;
use App\Kitchen\Cabinet\IngredientProperties\Name;
use App\Kitchen\Cabinet\IngredientProperties\Texture;
use App\Kitchen\Cabinet\IngredientQuantity;
use App\Kitchen\Cabinet\Rules\QuantityException;
use App\Kitchen\Finder\RecipeFinder;
use App\Kitchen\Calculator\TasteCalculator;
use Measurements\Measurement;
use Measurements\Units\UnitVolume;
use PHPUnit\Framework\TestCase;

class RecipeTest extends TestCase
{
    private Ingredient|array $ingredients = [];

    public function setUp(): void
    {

        $name = new Name("Butterscotch");
        $capacity = new Capacity(-1);
        $durability = new Durability(-2);
        $flavour = new Flavor(6);
        $texture = new Texture(3);
        $calories = new Calories(8);

        $this->ingredients[] = new Ingredient(
            $name,
            $capacity,
            $durability,
            $flavour,
            $texture,
            $calories
        );

        $this->ingredients[] = new Ingredient(
            new Name("Cinnamon"),
            new Capacity(2),
            new Durability(3),
            new Flavor(-2),
            new Texture(-1),
            new Calories(3),
        );

    }


    public function testRule()
    {

        $this->expectException(QuantityException::class);
        new Bowl(
            new Measurement(150, UnitVolume::teaspoons()),
            new IngredientQuantity(
                $this->ingredients[0],
                new Measurement(44, UnitVolume::teaspoons())
            ),
            new IngredientQuantity(
                $this->ingredients[1],
                new   Measurement(56, UnitVolume::teaspoons())
            ),
            new IngredientQuantity(
                $this->ingredients[1],
                new   Measurement(99, UnitVolume::teaspoons())
            ),
        );

    }

    public function testCalculator(): void
    {
        $bowl = new Bowl(
            new Measurement(100, UnitVolume::teaspoons()),
            new IngredientQuantity(
                $this->ingredients[0],
                new Measurement(44, UnitVolume::teaspoons())
            ),
            new IngredientQuantity(
                $this->ingredients[1],
                new   Measurement(56, UnitVolume::teaspoons())
            ),
        );


        $calculator = new TasteCalculator(
            $bowl,
        );

        self::assertEquals($calculator->getScore(), 62842880);

    }

    public function testRecipe(): void
    {

        $bowl = new Bowl(
            new Measurement(100, UnitVolume::teaspoons()),
            new IngredientQuantity(
                $this->ingredients[0],
                new Measurement(44, UnitVolume::teaspoons())
            ),
            new IngredientQuantity(
                $this->ingredients[1],
                new   Measurement(56, UnitVolume::teaspoons())
            ),
        );


        $calculator = new TasteCalculator(
            $bowl,
        );


        $finder = new RecipeFinder($bowl, $calculator);

        $recipe = $finder->find();

        self::assertSame(62842880, $recipe->getScore());
        self::assertEquals(100, $recipe->getContainer()->getVolume()->value());
        self::assertEquals(100, $recipe->getContainer()->getCapacity()->value());
        self::assertCount(2, $recipe->getContainer()->getIngredientQuantities());

    }


}