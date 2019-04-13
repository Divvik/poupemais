<?php

namespace Src\Core;
use PDO;
use Exception;
abstract class Models
{
    protected $db;

    public function __construct()
    {   

        try {
            $this->db = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DB_NAME ."; charset=utf8",DB_USER,DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            
            // Verifica se devemos debugar
            if(DEBUG) { $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); }

        } catch (PDOException $e) {
            // Verifica se devemos debugar 
            TrataErro::setErroExeption($e);
        }
    }
}