<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    private Project $project;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->project = $this->route('project');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'required', 'min:1', 'max:100'],
            'description' => ['sometimes', 'required', 'min:1', 'max:65535'],
            'image' => ['sometimes', 'required', 'image', 'max:64'],
            'live_demo_link' => ['sometimes', 'required', 'min:1', 'max:100'],
            'source_code_link' => ['sometimes', 'required', 'min:1', 'max:100'],
            'order' => ['sometimes', 'required', 'integer', 'min:1', "unique:projects,order,{$this->project->id},id"]
        ];
    }
}
