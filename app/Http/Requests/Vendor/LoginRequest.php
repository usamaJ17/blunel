<?php

namespace App\Http\Requests\Vendor;

use App\Enums\SessionKey;
use App\Http\Requests\Request;
use App\Traits\RecaptchaTrait;

class LoginRequest extends Request
{
    use RecaptchaTrait;

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
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => translate('the') . ' :attribute '.translate('field is required').'.'
        ];
    }
}
