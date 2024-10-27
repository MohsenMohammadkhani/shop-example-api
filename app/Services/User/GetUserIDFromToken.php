<?php

namespace App\Services\User;

use App\Services\Auth\JWTToken;

class GetUserIDFromToken
{

    public function  handler($authorizationHeader)
    {
        $jwtToken = str_replace("Bearer ", "", $authorizationHeader);
        $jwtTokenDecode = JWTToken::decode($jwtToken);
        return $jwtTokenDecode->user_id;
    }
}
