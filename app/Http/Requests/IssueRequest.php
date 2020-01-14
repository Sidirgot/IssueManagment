<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class IssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->isTester()) {
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
            return $this->createRules();
        }

        if ($this->isMethod('patch')) {
            return $this->updateRules();
        }
    }

    /**
     * Rules when creating an issue.
     *
     */
    protected function createRules()
    {
        return [
            'title' => ['required','string','max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'string', Rule::in(['high', 'medium', 'low'])],
        ];
    }

    /**
     * Rules when updating an issue.
     *
     */
    protected function updateRules()
    {
        return [
            'title' => ['sometimes','string','max:255'],
            'description' => ['sometimes', 'string', 'min:30'],
            'priority' => ['sometimes', 'string', Rule::in(['high', 'medium', 'low'])],
            'status' => ['sometimes', 'string', Rule::in(['opened', 'closed'])]
        ];
    }
}
