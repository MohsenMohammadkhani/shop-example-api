<?php

namespace App\Services\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static function encode($payload)
    {
        return JWT::encode($payload, env('JWY_SECRET'), 'HS256');
    }

    public static function decode($jwtToken)
    {
        return JWT::decode($jwtToken, new Key(env('JWY_SECRET'), 'HS256'));
    }
}
