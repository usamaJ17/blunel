<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminAddRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'role_id' => 'required',
            'image' => 'required',
            'email' => 'required|email|unique:admins',
            'password'=>'required|same:confirm_password|min:8',
            'phone'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => translate('name_is_required'),
            'role_id.required' => translate('role_id_is_required'),
            'image.required' => translate('image_is_required'),
            'email.required' => translate('email_is_required'),
            'email.email' => translate('email_must_be_valid'),
            'email.unique' => translate('email_already_in_use'),
            'password.required' => translate('password_is_required'),
            'phone.required' => translate('phone_is_required'),
        ];
    }

}
