<?php

namespace Src\Core;
use PDO;

abstract class Models
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DB_NAME, DB_USER,DB_PASSWORD);
    }
}