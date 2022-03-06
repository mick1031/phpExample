<?php

include '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class MyJwt{
    private static $_key = "a373e016-66b0-499b-b53d-49140ddef85e";

    public static function getToken($user) 
    {
        $key = self::$_key;
        $now = time();
        $expired = $now + (60 * 5);

        $payload = array(
            "iat" => $now,
            "exp" => $expired,
            "data" => $user,
        );
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
    
    public static function decodeToken($token)
    {
        $key = self::$_key;

        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return $decoded;
    }

    public static function verifyToken($token)
    {
        $info = self::decodeToken($token);
        
        return  time() < $info->exp;

    }
}


// $user = [
//     "name" => "mick"
// ];
// $token = MyJwt::getToken($user);
// var_dump($token);
// var_dump(MyJwt::decodeToken($token));
