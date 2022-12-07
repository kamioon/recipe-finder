<?php
declare(strict_types=1);

namespace App\Kitchen\Cabinet\Rules;

interface RuleInterface
{
    public function passes($object): bool;


}