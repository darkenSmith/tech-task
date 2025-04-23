<?php
namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Phone;
use App\Domain\User\ValueObjects\Country;
use App\Domain\User\ValueObjects\Gender;
use App\Domain\User\ValueObjects\Name;

class User
{
    private ?int $id;
    private Name $name;
    private Name $surname;
    private Email $email;
    private Phone $phone;
    private Country $country;
    private Gender $gender;
    private string $password;
    private ?string $profilePicture;

    public function __construct(
        Name $name,
        Name $surname,
        Email $email,
        Phone $phone,
        Country $country,
        Gender $gender,
        string $password,
        ?string $profilePicture = null
    ) {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->country = $country;
        $this->gender = $gender;
        $this->password = bcrypt($password);
        $this->profilePicture = $profilePicture;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getSurname(): Name
    {
        return $this->surname;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function update(
        Name $name,
        Name $surname,
        Email $email,
        Phone $phone,
        Country $country,
        Gender $gender,
        ?string $profilePicture = null
    ): void {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->country = $country;
        $this->gender = $gender;
        if ($profilePicture) {
            $this->profilePicture = $profilePicture;
        }
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
