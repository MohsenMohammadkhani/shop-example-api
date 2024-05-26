<?php

namespace App\Http\Requests\Auth\permission;

use App\Http\Requests\BaseRequests;
use Illuminate\Contracts\Validation\Validator;

class AddPermissionRequest extends BaseRequests
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
            'name' => 'required|string',
            'persian_name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('auth.permission_name_is_not_entered'),
            'name.string' => __('auth.permission_name_is_invalid'),

            'persian_name.required' => __('auth.permission_persian_name_is_not_entered'),
            'persian_name.string' => __('auth.permission_persian_name_is_invalid'),
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
