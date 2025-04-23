<?php
namespace App\Domain\User\ValueObjects;

use App\Domain\User\Countries;
use InvalidArgumentException;

class Country
{
    private string $value;

    public function __construct(string $country)
    {
        if (!in_array($country, Countries::all())) {
            throw new InvalidArgumentException('Invalid country');
        }
        $this->value = $country;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
