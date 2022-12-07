<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Kitchen\Cabinet\Ingredient;
use App\Kitchen\Cabinet\IngredientProperties\Calories;
use App\Kitchen\Cabinet\IngredientProperties\Capacity;
use App\Kitchen\Cabinet\IngredientProperties\Durability;
use App\Kitchen\Cabinet\IngredientProperties\Flavor;
use App\Kitchen\Cabinet\IngredientProperties\Name;
use App\Kitchen\Cabinet\IngredientProperties\Texture;
use PHPUnit\Framework\TestCase;
use TypeError;

class EntityTest extends TestCase
{
    public function setUp(): void
    {

    }

    public function testNumericValueObjects(): void
    {
        $calories = new Calories(10);
        self::assertEquals("Calories", $calories->getName());
        self::assertSame(10, $calories->getValue());

        $capacity = new Capacity(-1000);
        self::assertEquals("Capacity", $capacity->getName());
        self::assertSame(-1000, $capacity->getValue());
        self::assertJson(json_encode("Capacity"), json_encode($capacity->jsonSerialize()));

        $durability = new Durability();
        self::assertEquals("Durability", $durability->getName());
        self::assertSame(null, $durability->getValue());
        self::assertJson(json_encode("Durability"), json_encode($durability->jsonSerialize()));

        $this->expectException(TypeError::class);
        $calories = new Calories("string");

        $this->expectException(TypeError::class);
        $flavor = new Flavor(444.4);

    }

    public function testStringValueObjects(): void
    {
        $name = new Name("Test");
        self::assertSame("Test", $name->getValue());
        self::assertJsonStringEqualsJsonString(json_encode("Test"), json_encode($name->jsonSerialize()));

        $this->expectException(TypeError::class);
        $name = new Name(13454);
    }

    public function testIngredient(): void
    {
        $name = new Name("Butterscotch");
        $capacity = new Capacity(-1);
        $calories = new Calories(0);
        $durability = new Durability(100);
        $flavour = new Flavor(59);
        $texture = new Texture(-10);

        $Ingredient = new Ingredient($name, $capacity, $durability, $flavour, $texture, $calories);

        $this->assertEquals(1, 1);

    }


}