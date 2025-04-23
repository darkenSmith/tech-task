<?php
namespace App\Application\Actions\User;

use App\Domain\User\Services\UserService;

class GetUserAction
{
    private UserService $userService;
    private string $id;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function execute(int $id): \App\Domain\User\Entities\User
    {
        return $this->userService->getById($id);
    }
}
