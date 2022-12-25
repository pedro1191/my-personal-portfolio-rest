<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:1', 'max:100'],
            'description' => ['required', 'min:1', 'max:65535'],
            'image' => ['required', 'image', 'max:64'],
            'live_demo_link' => ['sometimes', 'required', 'min:1', 'max:100'],
            'source_code_link' => ['required', 'min:1', 'max:100'],
            'order' => ['required', 'integer', 'min:1', 'unique:projects,order'],
        ];
    }
}
