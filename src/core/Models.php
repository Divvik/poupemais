<?php

namespace Src\Core;
use PDO;

abstract class Models
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DB_NAME ."; charset=utf8",DB_USER,DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}