<?php

namespace App\Services\Auth\Login;

use App\Models\User;

class RegisterUserWithSmsCodeMobile
{

    public function register(string $userMobileNumber): User
    {
        $user = User::create([
            'mobile_number' => $userMobileNumber,
            'role_id' => env('ROLE_ID_DEFAULT_USER_WHEN_REGISTERED'),
        ]);
        if (!$user instanceof User) {
            throw new \Exception(__('auth.this_mobile_number_is_registered_already'));
        }
        return $user;
    }
}
