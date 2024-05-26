<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\BaseController;
use App\Services\Auth\JWTToken;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function init(Request $request)
    {
        try {
            $authorizationToken =  str_replace("Bearer ", "", $request->header('Authorization'));
            $tokenDecode = JWTToken::decode($authorizationToken);
            return $this->showResponse([
                'success' => true,
                'data' =>  $tokenDecode
            ], 200);
        } catch (\Exception $error) {
            $message = $error->getMessage();
            $this->showException(
                [
                    'success' => false,
                    'message' => $message,
                ],
                422
            );
        }
    }
}
