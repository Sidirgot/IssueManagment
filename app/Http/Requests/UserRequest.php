<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->isManager()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createUserRules();
        }

        if ($this->isMethod('patch')) {
            return $this->updateUserRules();
        }
    }

    /**
     * Validatation Rules while creating a user
     *
     * @return array rules
     */
    protected function createUserRules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string',  Rule::in(['tester','developer'])]
        ];
    }

    /**
     * Validatation Rules while updating a user
     *
     * @return array rules
     */
    protected function updateUserRules()
    {
        return [
            'name' => ['sometimes', 'string', 'max:255', 'unique:users,name,'. $this->user->id],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,'. $this->user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['sometimes','string', Rule::in(['tester','developer'])]
        ];
    }
}
