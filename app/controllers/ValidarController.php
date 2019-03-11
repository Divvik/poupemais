<?php

# Namespace
namespace App\Controllers;

# Classe Cadastrar
class ValidarController
{   
    private $erro = [];


    public function __construct()
    {
        $this->validarCadastro(
           $_POST
        );
        var_dump($this->getErro());
    }

    public function getErro()
    {
        return $this->erro;
    }

    public function setErro($erro)
    {
        array_push($this->erro, $erro);
    }

    # Valida se todos os campos desejados foram preenchidos
    public function validarCadastro($par = null)
    {
        $i = 0;

        foreach ($par as $key => $value) {
            echo $key . ' => ' . $value . '<br/>';
            // if(empty($value)) {
            //     $i++;
            // }
        }

        // if($i==0) {
        //     return true;
        // } else {
        //     $this->setErro('Preencha todos os dados!');
        //     return false;
        // }
    }
    
}