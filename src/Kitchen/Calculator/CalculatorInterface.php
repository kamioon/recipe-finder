<?php

namespace App\Kitchen\Calculator;

use App\Kitchen\Cabinet\ContainerInterface;

interface CalculatorInterface
{

    public function setContainer(ContainerInterface $container): self;

    public function getContainer(): ContainerInterface;

    public function getScore(): int;

    public function getPropertyScore(string $property): int;

    public function getCalculationProperties();

}