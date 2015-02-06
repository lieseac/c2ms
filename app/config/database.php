<?php

use \PDO;

return [
    'dsn' => 'mysql:host=localhost;dbname=c2ms2',
    'username' => 'root',
    'password' => '',
    'params' => [PDO::ATTR_PERSISTENT => true]
];