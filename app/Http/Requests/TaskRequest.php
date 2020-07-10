<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        $rules =  [

            'status' => 'required'

        ];
        if(!$this->route()->named('task.update')){
            $rules['name'] = 'required|min:3|max:25|unique:tasks';
            $rules['file_name'] = 'unique:tasks';
            $rules['project_id'] = 'required';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'unique' => ':attribute field already used',
        ];


    }
}
