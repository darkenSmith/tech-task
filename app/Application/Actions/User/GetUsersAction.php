<?php
namespace App\Application\Actions\User;

use App\Domain\User\Services\UserService;

class GetUsersAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function execute(): array
    {
        return $this->userService->getAll();
    }
}
