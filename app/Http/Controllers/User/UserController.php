<?php

namespace App\Http\Controllers\User;

use App\Application\Actions\CreateUserAction;
use App\Application\Actions\GetUserAction;
use App\Application\Actions\GetUsersAction;
use App\Application\DTOs\CreateUserDTO;
use App\Domain\User\Entities\User;
use App\Domain\User\ValueObjects\Name;
use App\Domain\User\ValueObjects\SurName;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
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

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user = $request->validated();
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

    public function destroy(){

    }

    public function update($id) {

    }
}
