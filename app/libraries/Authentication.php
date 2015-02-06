<?php

namespace Libraries;

class Authentication
{
    private static $salt = 'UJMp-MHYjH15c/jl>`FzCqA|^hih_d/w?NX4(5dD;,M@Vi%}QGORhAc|?I.;,gav';
    
    public static function generate($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10, 'salt' => self::$salt]);
    }
    
    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}