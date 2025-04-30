<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../vendor/autoload.php';

class JwtHelper {
    private static $secretKey = 'your_super_secret_key_12345'; 

    public static function encode($payload) {
        
        $payload['iat'] = time();
        $payload['exp'] = time() + (60 * 60); 
        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    public static function decode($token) {
        try {
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }
}
