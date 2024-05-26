<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequests;
use Illuminate\Contracts\Validation\Validator;

class SendSmsCodeForLoginRequest extends BaseRequests
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mobile-number' => 'required|string|min:11|max:11|regex:/^[0-9]+$/',
        ];
    }

    public function messages()
    {
        return [
            'mobile-number.required' => __('auth.mobile_number_is_not_entered'),
            'mobile-number.string' => __('auth.mobile_number_is_invalid'),
            'mobile-number.min' => __('auth.mobile_number_is_invalid'),
            'mobile-number.max' => __('auth.mobile_number_is_invalid'),
            'mobile-number.regex' => __('auth.mobile_number_is_invalid'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->showException([
            'success' => false,
            'message' => $validator->errors(),
        ], 422, [
            "Content-Type" => "application/json"
        ]);
    }
}
