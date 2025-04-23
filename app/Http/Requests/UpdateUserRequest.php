<?php

namespace App\Http\Requests;

use App\Domain\User\Countries;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'min:2'],
            'surname' => ['nullable', 'string', 'min:2'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'country' => ['nullable', Rule::in(Countries::all())],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'profile_picture' => ['nullable', 'string'],
        ];
    }
}
