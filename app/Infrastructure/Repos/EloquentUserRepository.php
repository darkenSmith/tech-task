<?php

namespace App\Infrastructure\Repos;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Phone;
use App\Domain\User\ValueObjects\Country;
use App\Domain\User\ValueObjects\Gender;
use App\Domain\User\ValueObjects\Name;
use App\Models\User as EloquentUser;

class EloquentUserRepository implements UserRepositoryInterface
{
	public function save(User $user): void
	{
		$eloquentUser = EloquentUser::updateOrCreate(
			[
				'name' => $user->getName()->getValue(),
				'surname' => $user->getSurname()->getValue(),
				'email' => $user->getEmail()->getValue(),
				'phone' => $user->getPhone()->getValue(),
				'country' => $user->getCountry()->getValue(),
				'gender' => $user->getGender()->getValue(),
				'password' => $user->getPassword(),
				'profile_picture' => $user->getProfilePicture(),
			]
		);
		$user->setId($eloquentUser->id);
	}

	public function findById(int $id): ?User
	{
		$eloquentUser = EloquentUser::find($id);
		if (!$eloquentUser) {
			return null;
		}

		$user = new User(
			new Name($eloquentUser->name),
			new Name($eloquentUser->surname),
			new Email($eloquentUser->email),
			new Phone($eloquentUser->phone),
			new Country($eloquentUser->country),
			new Gender($eloquentUser->gender),
			$eloquentUser->password,
			$eloquentUser->profile_picture
		);
		$user->setId($eloquentUser->id);
		return $user;
	}

	public function findByEmail(Email $email): ?User
	{
		$eloquentUser = EloquentUser::where('email', $email->getValue())->first();
		if (!$eloquentUser) {
			return null;
		}

		return new User(
			new Name($eloquentUser->name),
			new Name($eloquentUser->surname),
			new Email($eloquentUser->email),
			new Phone($eloquentUser->phone),
			new Country($eloquentUser->country),
			new Gender($eloquentUser->gender),
			$eloquentUser->password,
			$eloquentUser->profile_picture
		);
	}

	public function all(): array
	{
		return EloquentUser::all()->map(function ($eloquentUser) {
			return new User(
				new Name($eloquentUser->name),
				new Name($eloquentUser->surname),
				new Email($eloquentUser->email),
				new Phone($eloquentUser->phone),
				new Country($eloquentUser->country),
				new Gender($eloquentUser->gender),
				$eloquentUser->password,
				$eloquentUser->profile_picture
			);
		})->toArray();
	}

	public function delete(int $id): void
	{
		EloquentUser::destroy($id);
	}
}
