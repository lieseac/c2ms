<?php

namespace Libraries;

class Config
{
    protected static $buffer = [];

    public static function get($file)
    {
        if (!isset(self::$buffer[$file])) {
            self::$buffer[$file] = self::load($file);
        }
        
        return self::$buffer[$file];
    }
    
    public static function load($file)
    {
        return include(APP_PATH . '/config/' . $file . '.php');
    }
    
}