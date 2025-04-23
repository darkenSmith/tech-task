<?php
namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class Phone
{
    private string $value;

    public function __construct(string $phone)
    {
        if (preg_match('/^[0-9]{10}+$/', $phone)) {
            throw new InvalidArgumentException('Invalid phone number');
        }
        $this->value = $phone;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
