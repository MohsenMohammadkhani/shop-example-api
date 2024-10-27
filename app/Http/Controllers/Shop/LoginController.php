<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Auth\Login\LoginUserWithSmsCodeMobile;

class LoginController extends BaseController
{

    private $loginUserWithSmsCodeMobile;

    public function __construct()
    {
        $this->loginUserWithSmsCodeMobile = new LoginUserWithSmsCodeMobile();
    }

    public function loginWithSmsCode(Request $request)
    {
        try {
            $mobileNumber = $request->input("mobile-number");
            $smsCode = $request->input("sms-code");
            $products = $this->loginUserWithSmsCodeMobile->loginShop($mobileNumber, $smsCode);
            return $this->showResponse([
                'success' => true,
                'data' => $products
            ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("shop/product.get_product_failed"),
                ],
                422
            );
        }
    }
}
