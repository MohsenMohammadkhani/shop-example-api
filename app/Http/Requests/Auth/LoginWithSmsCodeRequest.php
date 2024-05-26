<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginWithSmsCodeRequest extends FormRequest
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
            'sms-code' => 'required|string|min:6|max:6|regex:/^[0-9]+$/',
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

            'sms-code.required' => __('auth.sms_code_for_login_user_is_not_entered'),
            'sms-code.string' => __('auth.sms_code_for_login_user_is_invalid'),
            'sms-code.min' => __('auth.sms_code_for_login_user_is_invalid'),
            'sms-code.max' => __('auth.sms_code_for_login_user_is_invalid'),
            'sms-code.regex' => __('auth.sms_code_for_login_user_is_invalid'),
        ];
    }
}
