<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\User\FillInfoRequest;
use App\Services\Auth\JWTToken;
use App\Services\User\FillInfo;
use App\Services\User\GetInfo;
use App\Services\User\GetUserIDFromToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    private $getUserIDFromToken;

    public function __construct()
    {
        $this->getUserIDFromToken = new GetUserIDFromToken();
    }

    public function fillUserInfo(FillInfoRequest $request)
    {
        try {
            $userID =  $this->getUserIDFromToken->handler($request->header('Authorization'));
            $fillInfo = new FillInfo();
            $fillInfo->handle($userID, $request->all());
            return $this->showResponse([
                'result' => true,
                'message' => __("dashboard/user.user_attributes_added_success"),
            ], 201);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("dashboard/user.user_attributes_added_failed"),
                ],
                422
            );
        }
    }

    public function getUserInfo(Request $request)
    {
        try {
            $getInfo = new GetInfo();
            $userID =  $this->getUserIDFromToken->handler($request->header('Authorization'));
            $userInfo =  $getInfo->handler($userID);
            if (!$userInfo) {
                $userInfo = [];
            }
            return $this->showResponse([
                'result' => true,
                'info' => $userInfo,
            ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            $this->showException(
                [
                    'result' => false,
                    'message' => __("dashboard/user.user_attributes_added_failed"),
                ],
                422
            );
        }
    }
}
