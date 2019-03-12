<?php

# Namespace
namespace App\Controllers;

# Classe Cadastrar
class ValidarController
{   
    private $erro = [];
    private $email;
    private $cpf;

    public function __construct()
    {
        $this->validaEmail('c_email');
        $this->validaCpf('c_cpf');

        $this->validarCadastro($_POST);
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
    public function validarCadastro($par)
    {
        $i = 0;

        foreach ($par as $key => $value) {
            if(empty($value)) {
                $i++;
            }
        }
        
        if($i==0) {
            return true;
            
        } else {
            $this->setErro('Preencha todos os dados!');
            return false;
        }
    }
    
    # Validação de email
    public function validaEmail($c_email)
    {
        if(isset($_POST[$c_email]) && !empty($_POST[$c_email])){

            $email = filter_input(INPUT_POST, $c_email, FILTER_VALIDATE_EMAIL);
            if(!$email) {
                $this->email = NULL;
                $this->setErro("Email inválido!");
                return false;
            }
        } else {
            $this->email = $email;
        }
    }

    public function validaCpf($c_cpf)
    {
        if(isset($_POST[$c_cpf]) && !empty($_POST[$c_cpf])){

            $cpf = filter_input(INPUT_POST, $c_cpf, FILTER_SANITIZE_SPECIAL_CHARS);
            
            if(!$cpf) {
                $this->cpf = NULL;
                $this->setErro("CPF inválido!");
                return false;

            } 
            $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);

            if(strlen($cpf) != 11) {
                $this->setErro("CPF Inválido!");
                return false;
            }

            for($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) $soma += $cpf{$i} * $j;
            
            $resto = $soma % 11;

            if($cpf{9} != ($resto < 2 ? 0 : 11 - $resto)) {
                $this->setErro("CPF Inválido!");
                return false;
            }
            for($i = 0, $j =11, $soma = 0; $i < 10; $i++, $j--) $soma += $cpf{$i} * $j;

            $resto = $soma % 11;

            $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
            
            $this->cpf = $cpf;
            
        }
    }
    
}