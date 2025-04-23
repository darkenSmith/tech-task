<?php

namespace Database\Factories;

use App\Domain\User\Countries;
use App\Domain\User\ValueObjects\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'surname' => fake()->lastname(),
            'phone' => fake()->phoneNumber,
            'country' => fake()->randomElement(Countries::all()),
            'gender' => \fake()->randomElement(['male', 'female']),
            'profile_picture' => fake()->imageUrl(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
