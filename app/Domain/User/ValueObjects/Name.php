<?php
namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class Name
{
    private string $value;

    public function __construct(string $name)
    {
        if (strlen($name) < 2) {
            throw new InvalidArgumentException('Name must be at least 2 characters');
        }
        $this->value = $name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
