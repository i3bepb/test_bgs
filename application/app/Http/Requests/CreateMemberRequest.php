<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMemberRequest extends FormRequest
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
            'name' => [
                'bail',
                'required',
                'string',
                'max:100',
            ],
            'surname' => [
                'bail',
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'bail',
                'required',
                'email:filter',
                'unique:member,email',
            ],
            'eventIds' => [
                'bail',
                'required',
                'array',
            ],
            'eventIds.*' => [
                'exists:event,id'
            ],
        ];
    }
}
