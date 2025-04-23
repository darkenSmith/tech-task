<?php
namespace App\Domain\User\Services;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Name;
use App\Domain\User\ValueObjects\Phone;
use App\Domain\User\ValueObjects\Country;
use App\Domain\User\ValueObjects\Gender;
use App\Domain\User\Exceptions\UserException;

class UserService
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws UserException
     */
    public function create(
        Name $name,
        Name $surname,
        Email $email,
        Phone $phone,
        Country $country,
        Gender $gender,
        string $password,
        ?string $profilePicture
    ): User {
        if ($this->repository->findByEmail($email)) {
            throw new UserException('User with this email already exists');
        }

        $user = new User($name, $surname, $email, $phone, $country, $gender, $password, $profilePicture);
        $this->repository->save($user);
        return $user;
    }

    /**
     * @throws UserException
     */
    public function update(
        int $id,
        Name $name,
        Name $surname,
        Email $email,
        Phone $phone,
        Country $country,
        Gender $gender,
        ?string $profilePicture
    ): User {
        $user = $this->repository->findById($id);
        if (!$user) {
            throw new UserException('User not found');
        }

        $user->update($name, $surname, $email, $phone, $country, $gender, $profilePicture);
        return $user;
    }

    /**
     * @throws UserException
     */
    public function getById(int $id): User
    {
        $user = $this->repository->findById($id);
        if (!$user) {
            throw new UserException('User not found');
        }
        return $user;
    }

    public function getAll(): array
    {
        return $this->repository->all();
    }

    /**
     * @throws UserException
     */
    public function delete(int $id): void
    {
        if (!$this->repository->findById($id)) {
            throw new UserException('User not found');
        }
        $this->repository->delete($id);
    }
}
