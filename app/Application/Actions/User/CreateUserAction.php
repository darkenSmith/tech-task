<?php
namespace App\Application\Actions\User;

use App\Application\DTOs\CreateUserDTO;
use App\Domain\User\Exceptions\UserException;
use App\Domain\User\Services\UserService;
use App\Domain\User\ValueObjects\Country;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Gender;
use App\Domain\User\ValueObjects\Name;
use App\Domain\User\ValueObjects\Phone;

class CreateUserAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws UserException
     */
    public function execute(CreateUserDTO $dto): \App\Domain\User\Entities\User
    {
        $name = new Name($dto->name);
        $surname = new Name($dto->surname);
        $email = new Email($dto->email);
        $phone = new Phone($dto->phone);
        $country = new Country($dto->country);
        $gender = new Gender($dto->gender);

        return $this->userService->create(
            $name,
            $surname,
            $email,
            $phone,
            $country,
            $gender,
            $dto->password,
            $dto->profilePicture
        );
    }
}
