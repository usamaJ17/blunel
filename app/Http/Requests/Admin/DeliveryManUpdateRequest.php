<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

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
class DeliveryManUpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('delivery_men', 'email')->ignore($this->route('id')),
            ],
            'phone' => 'required',
            'country_code' => 'required',
        ];
        if ($this['password']) {
            $rules['password'] = 'required|same:confirm_password|min:8';
        }
        return $rules;
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
        ];
    }

}
