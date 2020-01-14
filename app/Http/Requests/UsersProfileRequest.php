<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'string', 'max:255', 'unique:users,name,'. $this->user->id],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,'. $this->user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
