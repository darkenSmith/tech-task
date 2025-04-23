<?php
namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class SurName
{
    private string $value;

    public function __construct(string $surname)
    {
        if (strlen($surname) < 2) {
            throw new InvalidArgumentException('Name must be at least 2 characters');
        }
        $this->value = $surname;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
