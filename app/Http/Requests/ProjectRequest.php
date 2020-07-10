<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
$rules = [
];
        if(!$this->route()->named('project.show'))
        {
            $rules['name'] = 'required|min:3|max:25|unique:projects';
        }
        return $rules;
    }
}
