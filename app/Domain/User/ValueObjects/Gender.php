<?php
namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class Gender
{
    private string $value;

    public function __construct(string $gender)
    {
        $allowed = ['male', 'female', 'other'];
        if (!in_array(strtolower($gender), $allowed)) {
            throw new InvalidArgumentException('Invalid gender');
        }
        $this->value = strtolower($gender);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
