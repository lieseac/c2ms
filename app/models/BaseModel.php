<?php

namespace Models;
use Libraries\Database;

class BaseModel
{
    protected $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}