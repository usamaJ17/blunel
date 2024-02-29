<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RefundStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
        public function rules(): array
        {
            return [
                'id' => 'required',
                'refund_status' => 'required|in:pending,approved,rejected,refunded',
                'approved_note' => $this->input('refund_status') == 'approved' ? 'required' : '',
                'rejected_note' => $this->input('refund_status') == 'rejected' ? 'required': '',
            ];
        }
    }
