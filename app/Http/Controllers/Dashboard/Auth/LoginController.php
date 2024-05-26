<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginWithSmsCodeRequest;
use App\Http\Requests\Auth\SendSmsCodeForLoginRequest;
use App\Services\Auth\Login\LoginUserWithSmsCodeMobile;

class LoginController extends BaseController
{

    private $loginUserWithSmsCodeMobile;

    public function __construct()
    {
        $this->loginUserWithSmsCodeMobile = new LoginUserWithSmsCodeMobile();
    }

    public function sendSmsCodeForLogin(SendSmsCodeForLoginRequest $request)
    {
        try {
            $mobileNumber = $request->input("mobile-number");
            $this->loginUserWithSmsCodeMobile->sendSmsCodeForLoginUser($mobileNumber);
            return $this->showResponse([
                'success' => true,
                'message' => __('auth.sms_code_for_login_user_send_success'),
            ], 201);
        } catch (\Exception $error) {
            $this->showException(
                [
                    'success' => false,
                    'message' => $error->getMessage(),
                ]
                , 422);
        }
    }

    public function login(LoginWithSmsCodeRequest $request)
    {
        try {
            $mobileNumber = $request->input("mobile-number");
            $smsCode = $request->input("sms-code");
            $jwtToken = $this->loginUserWithSmsCodeMobile->login($mobileNumber, $smsCode);
            return $this->showResponse([
                'success' => true,
                'token' => $jwtToken,
            ], 201);
        } catch (\Exception $error) {
            $this->showException(
                [
                    'success' => false,
                    'message' => $error->getMessage(),
                ]
                , 422);
        }
    }

}
