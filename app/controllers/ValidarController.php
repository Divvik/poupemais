<?php

# Namespace
namespace App\Controllers;
use App\Models\CadastrarDB;
use App\Controllers\PasswordController;


# Classe Cadastrar
class ValidarController
{   
    private $erro = [];
    private $cadastro;
    private $nome;
    private $cpf;
    private $rg;
    private $estado_civil;
    private $endereco;
    private $bairro;
    private $cep;
    private $cidade;
    private $estado;
    private $telefone;
    private $email;
    private $login;
    private $senha;
    private $hashSenha;
    private $confSenha;
    private $dataCreate;
    private $token;
    private $status = 'confirmation';

    public function __construct()
    {
        
        $this->cadastro = new CadastrarDB();
                
        $this->validarCadastro($_POST);
        $this->validarFields();
        $this->validaEmail('c_email');
        $this->validaIssetEmail($this->email);
        $this->validaCpf('c_cpf');

        var_dump($this->getErro());

        $this->cadastro->insert(
            $this->email,
            $this->hashSenha,
            $this->login,
            $this->nome,
            $this->cpf,
            $this->rg,
            $this->estado_civil,
            $this->endereco,
            $this->bairro,
            $this->cep,
            $this->cidade,
            $this->estado,
            $this->telefone,
            $this->dataCreate,
            $this->status,
            $this->token
        );
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
            } else {
                $this->email = $email;
            }
        }
    }

    #Valida se email existe no banco de dados
    public function validaIssetEmail($email)
    {
        $b = $this->cadastro->getEmail($email);

        if($b > 0) {
            $this->setErro("Email já cadastrado!");
            return false;
        } else {
            return true;
        }
    }

    # Valida CPF
    public function validaCpf($c_cpf)
    {
        if(isset($_POST[$c_cpf]) && !empty($_POST[$c_cpf])){

            $cpf = filter_input(INPUT_POST, $c_cpf, FILTER_SANITIZE_SPECIAL_CHARS);
            // Extrai somente os números
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
            
            // Verifica se foi informado todos os digitos corretamente
            if (strlen($cpf) != 11) {
                $this->setErro("Digite 11 números do CPF!");
                return false;
            }
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                $this->setErro("CPF não aceita números sequencias!");
                return false;
            }
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $this->setErro("CPF Inválido!");
                    return false;
                }
            }
            $this->cpf = $cpf;
        } else {
            $this->cpf = NULL;
        }
    }
    
    # Valida os campos vindo do formulario
    public function validarFields()
    {
        (isset($_POST['c_nome']) && !empty($_POST['c_nome']) ? $this->nome = filter_input_post('c_nome') : $this->nome = null); 

        (isset($_POST['c_cpf']) && !empty($_POST['c_cpf']) ? $this->cpf = filter_input_post('c_cpf') : $this->cpf = null);

        (isset($_POST['c_rg']) && !empty($_POST['c_rg']) ? $this->rg = filter_input_post('c_rg') : $this->rg = null);

        (isset($_POST['c_estado_civil']) && !empty($_POST['c_estado_civil']) ? $this->estado_civil = filter_input_post('c_estado_civil') : $this->estado_civil = null);

        (isset($_POST['c_endereco']) && !empty($_POST['c_endereco']) ? $this->endereco = filter_input_post('c_endereco') : $this->endereco = null);

        (isset($_POST['c_bairro']) && !empty($_POST['c_bairro']) ? $this->bairro = filter_input_post('c_bairro') : $this->bairro = null);

        (isset($_POST['c_cep']) && !empty($_POST['c_cep']) ? $this->cep = filter_input_post('c_cep') : $this->cep = null);

        (isset($_POST['c_cidade']) && !empty($_POST['c_cidade']) ? $this->cidade = filter_input_post('c_cidade') : $this->cidade = null);

        (isset($_POST['c_estado']) && !empty($_POST['c_estado']) ? $this->estado = filter_input_post('c_estado') : $this->estado = null);

        (isset($_POST['c_telefone']) && !empty($_POST['c_telefone']) ? $this->telefone = filter_input_post('c_telefone') : $this->telefone = null);

        (isset($_POST['c_email']) && !empty($_POST['c_email']) ? $this->email = filter_input(INPUT_POST, 'e_email', FILTER_VALIDATE_EMAIL) : $this->email = null);

        (isset($_POST['c_login']) && !empty($_POST['c_login']) ? $this->login = filter_input_post('c_login') : $this->login = null);

        $objPass = new PasswordController();
        if(isset($_POST['c_senha']) && !empty($_POST['c_senha'])) { 
            
            $senha = '709244'; 
            $this->hashSenha = $objPass->passwordHash($senha);
        } else{
            $this->hashSenha = null; 
        }
        if(isset($_POST['c_conf-senha']) && !empty($_POST['c_conf-senha'])) {
            $this->confSenha = filter_input_post('c_conf-senha');

        } else{
            $this->confSenha = null; 
        }
        $this->dataCreate = date("Y-m-d H:i:s");
        
        $this->token=bin2hex(random_bytes(64));
    }
}