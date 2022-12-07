<?php

declare(strict_types=1);

namespace Domain;


use App\Kitchen\Cabinet\ValueObject\Calories;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function setUp(): void
    {

    }

    public function testCalories(): void
    {
        $calories = new Calories();
        self::assertEquals($calories->getName(), "Calories");
    }

}