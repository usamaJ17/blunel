<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
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
            'phone'  => 'required|unique:sellers,phone,'.$this->id,
        ];
    }

    /**
     * @return array
     */
    public function messages():array
    {
        return [
            'f_name.required' => translate('first_name_is_required').'!',
            'l_name.required' =>translate('last_name_is_required').'!',
            'phone.required' =>translate('phone_number_is_required').'!',
        ];
    }
}
