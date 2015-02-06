<?php

namespace Libraries;

class ClassLoader
{
    
    public static function load($className)
    {
        $classPath = APP_PATH . '/' . $className . '.php';
        require($classPath);
        return true;
    }
    
    public static function register()
    {
        spl_autoload_register(['Libraries\ClassLoader', 'load'], true);
    }
}