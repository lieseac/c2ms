<?php

namespace Libraries;
use \PDO;

class Database
{
    protected static $db;
    
    public static function getInstance()
    {
        if (!isset(self::$db)) {
            self::$db = self::build();
        }
        
        return self::$db;
    }
    
    protected static function build()
    {
        $config = Config::load('database');
        $db = new PDO($config['dsn'], $config['username'], $config['password'], $config['params']);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $db;
    }
}