<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateMemberRequest extends CreateMemberRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['email'] = [
            'bail',
            'required',
            'email:filter',
            Rule::unique('member', 'email')->ignore($this->query('id'), 'id'),
        ];
        return $rules;
    }
}
