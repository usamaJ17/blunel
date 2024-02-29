<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

/**
 * Class DeliveryManAddRequest
 *
 * @property int $id
 * @property string $f_name
 * @property string $l_name
 * @property string $phone
 * @property string $email
 * @property string $country_code
 * @property string $password
 * @property string $confirm_password
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class DeliveryManAddRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required|unique:delivery_men',
            'email' => 'required|unique:delivery_men',
            'country_code' => 'required',
            'password' => 'required|same:confirm_password|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'f_name.required' => translate('The_first_name_field_is_required'),
            'l_name.required' => translate('The_last_name_field_is_required'),
            'phone.required' => translate('The_phone_field_is_required'),
            'email.required' => translate('The_email_field_is_required'),
            'email.unique' => translate('The_email_has_already_been_taken'),
            'country_code.required' => translate('The_country_code_field_is_required'),
            'password.required' => translate('The_password_field_is_required'),
            'password.same' => translate('The_password_and_confirm_password_must_match'),
            'password.min' => translate('The_password_must_be_at_least :min_characters', ['min' => 8]),
        ];
    }

}
