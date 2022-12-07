<?php

final class Unit implements UnitInterface
{

    public function __construct(
        private readonly string  $name,
        private readonly ?string $symbol
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): null|string
    {
        return $this->symbol;
    }
}