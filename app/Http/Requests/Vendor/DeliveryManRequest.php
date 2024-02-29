<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryManRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:delivery_men,email',
            'identity_image.0' => 'required|mimes:jpg,jpeg,png,webp',
            'image' => 'required|mimes:jpg,jpeg,png,webp',
            'country_code' => 'required',
            'password' => 'required|same:confirm_password|min:8'
        ];
    }
    /**
     * @return array
     * Get the validation error message
     */
    public function messages(): array
    {
        return [
            'f_name.required' => translate('The_first_name_field_is_required'),
            'l_name.required' => translate('The_last_name_field_is_required'),
            'phone.required' => translate('The_phone_field_is_required'),
            'email.required' => translate('The_email_field_is_required'),
            'email.unique' => translate('The_email_has_already_been_taken'),
            'country_code.required' => translate('The_country_code_field_is_required'),
            'password.same' => translate('The_password_and_confirm_password_must_be_match'),
            'password.min' => translate('The_password_must_be_at_least :min_characters', ['min' => 8]),
        ];
    }
}
