<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class RegistrationRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'password' => ['required', 'string', 'min:4'],
        ];
    }
}
