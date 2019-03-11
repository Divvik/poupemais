<?php

# Namespace
namespace App\Controllers;

use Helpers\variaveis;

# Classe Cadastrar
class ValidarController
{   
    private $erro = [];

    public function __construct()
    {
        
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
    public function validarCadastro($par = null)
    {
        $i = 0;

        foreach ($par as $key => $value) {
            if(empty($value)) {
                $i++;
            }
            echo $key . ' => ' . $value . '<br/>';
        }

        if($i==0) {
            return true;
        } else {
            $this->setErro('Preencha todos os dados!');
            return false;
        }
    }
    
    private function getPost()
    {
        // (isset($_POST['c_nome']) && !empty($_POST['c_nome']) ? $this->nome = filter_input_post('c_nome') : $this->nome = null);

        // (isset($_POST['c_cpf']) && !empty($_POST['c_cpf']) ? $cpf = filter_input_post('c_cpf') : $cpf = null);

        // (isset($_POST['c_endereco']) && !empty($_POST['c_endereco']) ? $endereco = filter_input_post('c_endereco') : $endereco = null);

        // (isset($_POST['c_bairro']) && !empty($_POST['c_bairro']) ? $bairro = filter_input_post('c_bairro') : $bairro = null);

        // (isset($_POST['c_cep']) && !empty($_POST['c_cep']) ? $cep = filter_input_post('c_cep') : $cep = null);

        // (isset($_POST['c_cidade']) && !empty($_POST['c_cidade']) ? $cidade = filter_input_post('c_cidade') : $cidade = null);

        // (isset($_POST['c_estado']) && !empty($_POST['c_estado']) ? $estado = filter_input_post('c_estado') : $estado = null);

        // (isset($_POST['c_telefone']) && !empty($_POST['c_telefone']) ? $telefone = filter_input_post('c_telefone') : $telefone = null);

        // (isset($_POST['c_email']) && !empty($_POST['c_email']) ? $email = filter_input(INPUT_POST, 'c_email', FILTER_VALIDATE_EMAIL) : $email = null);

        // (isset($_POST['c_login']) && !empty($_POST['c_login']) ? $login = filter_input_post('c_login') : $login = null);

        // if(isset($_POST['c_senha']) && !empty($_POST['c_senha'])) { 
        //     $senha = filter_input_post('c_senha'); 
        //     $hashSenha = '';
        // } else{
        //     $senha = null; 
        //     $hashSenha = null;
        // }
        // if(isset($_POST['c_senha']) && !empty($_POST['c_senha'])) {
        //     $confSenha = filter_input_post('c_senha'); 
        // } else{
        //     $confSenha = null; 
        // }
        // $dataCreate = date("Y-m-d H:i:s");
        // $token=bin2hex(random_bytes(64));
        

        // $post = [
        //     "nome" => $this->nome,         "cpf" => $cpf,
        //     "endereco" => $endereco, "bairro" => $bairro, 
        //     "cep" => $cep,           "cidade" => $cidade, 
        //     "estado" => $estado,     "telefone" => $telefone, 
        //     "email" => $email,       "login" => $login, 
        //     "senha" => $senha
        //     ];
        // return $post;
    }
}