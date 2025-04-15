<?php

namespace App\Http\Requests;

class ClassifiedUpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}
