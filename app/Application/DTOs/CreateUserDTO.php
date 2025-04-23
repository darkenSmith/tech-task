<?php
namespace App\Application\DTOs;

class CreateUserDTO
{
    public string $name;
    public string $surname;
    public string $email;
    public string $phone;
    public string $country;
    public string $gender;
    public string $password;
    public ?string $profilePicture;

    public function __construct(
        string $name,
        string $surname,
        string $email,
        string $phone,
        string $country,
        string $gender,
        string $password,
        ?string $profilePicture = null
    ) {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->country = $country;
        $this->gender = $gender;
        $this->password = $password;
        $this->profilePicture = $profilePicture;
    }
}
