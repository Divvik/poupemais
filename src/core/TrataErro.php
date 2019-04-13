<?php

namespace Src\Core;

class TrataErro
{   
    // Trata erro conforme o Debug
    public static function setErroExeption($erro)
    {
        if(DEBUG){
            echo "<pre>";
                print_r($erro);
            echo "</pre>";
        }else {
            echo "Erro: " . $erro->getMessage();
        }
        exit;
    }
    
    // Mostra o Erro dependendo do Debug
    public static function setErroDegub()
    {
        // Verifica o modo para debugar
        if ( ! defined('DEBUG') || DEBUG === false ) {

            // Esconde todos os erros
            error_reporting(0);
            ini_set("display_errors", 0); 
            
        } else {

            // Mostra todos os erros
            error_reporting(E_ALL);
            ini_set("display_errors", 1); 
            
        }
    }
}