<?php
namespace App\Application\Actions\User;

use App\Domain\User\Services\UserService;

class DeleteUserAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function execute(int $id): void
    {
        $this->userService->delete($id);
    }
}
