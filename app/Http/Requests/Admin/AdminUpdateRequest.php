<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'role_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($this->route('id')),
            ],
        ];
        if ($this['password']) {
            $rules['password'] = 'required|same:confirm_password|min:8';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => translate('name_is_required'),
            'role_id.required' => translate('role_id_is_required'),
            'email.required' => translate('email_is_required'),
            'email.email' => translate('email_must_be_valid'),
            'email.unique' => translate('email_already_taken'),
        ];
    }

}
