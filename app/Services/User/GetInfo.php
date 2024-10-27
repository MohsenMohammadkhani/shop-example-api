<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\UserAttributes;

class GetInfo
{

    public function handler(int $userID)
    {
        $user = User::findOrFail($userID);

        $userAttributes = UserAttributes::where('user_id', $userID)->first();
        if (!$userAttributes) {
            return false;
        }

        $userAttributes = $userAttributes->getAttributes();
        $userAttributes['mobile_number'] = $user->mobile_number;
        return $userAttributes;
    }
}
