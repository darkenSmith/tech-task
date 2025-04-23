<?php
namespace App\Domain\User;

enum Countries: string
{
    case USA = 'United States';
    case UK = 'United Kingdom';
    case CANADA = 'Canada';
    case AUSTRALIA = 'Australia';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
