<?php
namespace App\Application\Actions;

use App\Application\DTOs\UpdateUserDTO;
use App\Domain\User\Services\UserService;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Phone;
use App\Domain\User\ValueObjects\Country;
use App\Domain\User\ValueObjects\Gender;
use App\Domain\User\ValueObjects\Name;

class UpdateUserAction
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function execute(int $id, UpdateUserDTO $dto): \App\Domain\User\Entities\User
    {
        $name = new Name($dto->name);
        $surname = new Name($dto->surname);
        $email = new Email($dto->email);
        $phone = new Phone($dto->phone);
        $country = new Country($dto->country);
        $gender = new Gender($dto->gender);

        return $this->userService->update(
            $id,
            $name,
            $surname,
            $email,
            $phone,
            $country,
            $gender,
            $dto->profilePicture
        );
    }
}
