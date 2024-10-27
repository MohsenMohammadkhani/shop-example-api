<?php

namespace App\Http\Requests\Dashboard\Auth\role;

use App\Http\Requests\BaseRequests;
use Illuminate\Contracts\Validation\Validator;

class SetPermissionsToRole extends BaseRequests
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
            "permissions_ids" => "required|string"
        ];
    }

    public function messages()
    {
        return [
            'permissions_ids.required' => __('auth.permissions_ids_is_not_entered'),
            'permissions_ids.string' => __('auth.permissions_ids_is_invalid'),
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
