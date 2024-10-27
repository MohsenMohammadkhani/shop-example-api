<?php

namespace App\Services\User;

use App\Models\UserAttributes;

class FillInfo
{

    public function handle(int $userID, $userInfo)
    {
        $userAttributes = UserAttributes::where('user_id', $userID)->first();
        if (!$userAttributes) {
            UserAttributes::create(
                [
                    "user_id" => $userID,
                    ...(array) $userInfo,
                ]
            );
            return;
        }
        $userAttributes->delete();
        UserAttributes::create(
            [
                "user_id" => $userID,
                ...(array)  $userInfo,
            ]
        );
    }
}
