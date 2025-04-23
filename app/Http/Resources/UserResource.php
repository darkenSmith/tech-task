<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->getId(),
                'name' => $this->getName()->getValue(),
                'surname' => $this->getSurname()->getValue(),
                'email' => $this->getEmail()->getValue(),
                'phone' => $this->getPhone()->getValue(),
                'country' => $this->getCountry()->getValue(),
                'gender' => $this->getGender()->getValue(),
                'profile_picture' => $this->getProfilePicture() ? asset('storage/' . $this->getProfilePicture()) : null,
            ]
        ];
    }
}
