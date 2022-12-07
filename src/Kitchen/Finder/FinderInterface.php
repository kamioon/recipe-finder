<?php

namespace App\Kitchen\Finder;


use App\Kitchen\Cabinet\ContainerInterface;
use App\Kitchen\Recipe\RecipeInterface;

interface FinderInterface
{
    public function find(): RecipeInterface;

}