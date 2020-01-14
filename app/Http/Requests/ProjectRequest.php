<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            return $this->createRules();
        }

        if ($this->isMethod('patch')) {
            return $this->updateRules();
        }
    }

    /**
     * Update Project Status based on the status value past from the request.
     *
     * @param Project $project
     * @return void
     */
    public function updateProjectStatus(Project $project)
    {
        $this->status === 'closed' ? $project->close() : $project->open();

        return $project;
    }

    /**
     * Validatation Rules while creating a project
     *
     * @return array rules
     */
    protected function createRules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
        ];
    }

    /**
     * Validatation Rules while updating a project
     *
     * @return array rules
     */
    protected function updateRules()
    {
        return [
            'title' => ['sometimes', 'string','max:255'],
            'description' => ['sometimes'],
            'status' => ['sometimes','string', Rule::in(['closed','opened'])]
        ];
    }
}
