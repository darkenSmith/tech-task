<?php

namespace App\Http\Controllers\User;

use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\GetUserAction;
use App\Application\Actions\User\GetUsersAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\DTOs\CreateUserDTO;
use App\Application\DTOs\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(GetUsersAction $action): JsonResponse
    {
        $users = $action->execute();
        return response()->json(UserResource::collection($users));
    }

    public function store(CreateUserRequest $request, CreateUserAction $action): JsonResponse {
        $user = $request->validated();

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user = new CreateUserDTO(
            $user['name'],
            $user['surname'],
            $user['email'],
            $user['phone'],
            $user['country'],
            $user['gender'],
            $user['password'],
            $profilePicturePath
        );

        $user = $action->execute($user);
        return response()->json(new UserResource($user), 201);
    }

    public function show($id, GetUserAction $action): JsonResponse {
        $user = $action->execute($id);
        return response()->json(new UserResource($user));
    }

    public function destroy($id, DeleteUserAction $action): JsonResponse {
        $action->execute($id);
        return response()->json(null, 204);
    }

    public function update($id, UpdateUserRequest $request, UpdateUserAction $action): JsonResponse {
        $user = $request->validated();
        $profilePicturePath = null;

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user = new UpdateUserDTO(
            $user['name'] ?? null,
            $user['surname'] ?? null,
            $user['email'] ?? null,
            $user['phone'] ?? null,
            $user['country'] ?? null,
            $user['gender'] ?? null,
            $profilePicturePath
        );
        $user = $action->execute($id, $user);
        return response()->json(new UserResource($user));
    }
}
