<?php

namespace App\Services\Auth\Login;

use App\Models\Role;
use App\Models\User;
use App\Notifications\auth\SendSmsLoginToDashboard;
use App\Services\Auth\JWTToken;

class LoginUserWithSmsCodeMobile
{

    private $registerUserWithSmsCodeMobile;

    public function __construct()
    {
        $this->registerUserWithSmsCodeMobile = new RegisterUserWithSmsCodeMobile();
    }

    public function sendSmsCodeForLoginUser(string $mobileNumber)
    {
        $user = User::where('mobile_number', $mobileNumber)->first();
        if (!$user) {
            $user = $this->registerUserWithSmsCodeMobile->register($mobileNumber);
        }
        $loginCode = random_int(100000, 999999);
        $user->login_code = $loginCode;
        $user->save();
        $this->smsCodeLoginToMobileNumberUser($user, array($mobileNumber), $loginCode);
    }

    private function smsCodeLoginToMobileNumberUser($user, $mobilesNumber, $loginCode)
    {
        $user->notify(new SendSmsLoginToDashboard($mobilesNumber, $loginCode));
    }

    public function login(string $mobileNumber, string $smsCode): string
    {
        $user = User::where('mobile_number', $mobileNumber)->first();
        if (!$user) {
            throw new \Exception(__('auth.user_with_this_mobile_number_is_not_exist'));
        }
        if ($user->login_code != $smsCode) {
            throw new \Exception(__('auth.sms_code_for_login_user_is_invalid'));
        }

        $userRole = $user->roles;
        $userPermissions = Role::findOrFail($userRole->id)->permissions()->select(array('name'))->get()->map(function ($item) {
            return $item->name;
        })->toArray();

        return JWTToken::encode(
            [
                'user_id' => $user->id,
                'user_mobile_number' => $user->mobile_number,
                'role' =>
                array(
                    "name" => $userRole->attributesToArray()['name'],
                    "persian_name" => $userRole->attributesToArray()['persian_name'],
                ),
                'permissions' => $userPermissions,
            ]
        );
    }
}
