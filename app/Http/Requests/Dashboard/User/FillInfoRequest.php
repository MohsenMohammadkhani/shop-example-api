<?php

namespace App\Http\Requests\Dashboard\User;

use App\Http\Requests\BaseRequests;
use Illuminate\Contracts\Validation\Validator;

class FillInfoRequest extends BaseRequests
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
            'first-name' => 'required|string',
            'last-name' => 'required|string',
            'national-code' => 'required|integer',
            'birthday' => 'required|string',
            'gender' => 'required|integer',
            'aaa' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first-name.required' => __('dashboard/user.first_name_is_not_entered'),
            'first-name.string' => __('dashboard/user.first_name_is_invalid'),

            'last-name.required' => __('dashboard/user.last_name_is_not_entered'),
            'last-name.string' => __('dashboard/user.last_name_is_invalid'),

            'national-code.required' => __('dashboard/user.national_code_is_not_entered'),
            'national-code.integer' => __('dashboard/user.national_code_is_invalid'),

            'birthday.required' => __('dashboard/user.birthday_is_not_entered'),
            'birthday.string' => __('dashboard/user.birthday_is_invalid'),

            'gender.required' => __('dashboard/user.gender_is_not_entered'),
            'gender.integer' => __('dashboard/user.gender_is_invalid'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $validatorErrors =  $validator->errors()->messages();
        $validatorErrors = reset($validatorErrors);
        $this->showException([
            'success' => false,
            // 'message' => $validator->errors(),
            'message' => reset($validatorErrors)[0],
        ], 422, [
            "Content-Type" => "application/json"
        ]);
    }
}
