<?php

# Declarando namespace
namespace App\Controllers;

# Declarando use
use Src\Core\Controllers;
use App\Models\CadastrarDB;
use Src\Core\PasswordController;
use App\Controllers\ValidarController;
use PDO;
use Src\Core\Mail;

# Declarando a class
class CadastroController extends Controllers
{   
    # variaveis classes
    private $valida;
    private $cadastroDB;

    # Variaveis formulario
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
    private $plano;
    private $token;
    private $status = 'confirmation';
    private $gRecaptchaResponse;

    public function index()
    {   
        # Instanciando cadastrarDB
        $this->cadastroDB = new CadastrarDB;
        # selecionando os planos
        $dados = $this->cadastroDB->selectPlano();
        $this->view->render('cadastro/cadastro', ['planos' => $dados]);
    }

    # Valida Fields
    # Valida os campos vindo do formulario
    public function validarFields()
    {   
        # Validando os campos 
        (isset($_POST['c_nome']) && !empty($_POST['c_nome']) ? $this->nome = filter_input_post('c_nome') : $this->nome = null);
        (isset($_POST['c_rg']) && !empty($_POST['c_rg']) ? $this->rg = filter_input_post('c_rg') : $this->rg = null);
        (isset($_POST['c_cpf']) && !empty($_POST['c_cpf']) ? $this->cpf = filter_input_post('c_cpf') : $this->cpf = null);
        (isset($_POST['c_estado_civil']) && !empty($_POST['c_estado_civil']) ? $this->estado_civil = filter_input_post('c_estado_civil') : $this->estado_civil = null);
        (isset($_POST['c_endereco']) && !empty($_POST['c_endereco']) ? $this->endereco = filter_input_post('c_endereco') : $this->endereco = null);
        (isset($_POST['c_bairro']) && !empty($_POST['c_bairro']) ? $this->bairro = filter_input_post('c_bairro') : $this->bairro = null);
        (isset($_POST['c_cep']) && !empty($_POST['c_cep']) ? $this->cep = filter_input_post('c_cep') : $this->cep = null);
        (isset($_POST['c_cidade']) && !empty($_POST['c_cidade']) ? $this->cidade = filter_input_post('c_cidade') : $this->cidade = null);
        (isset($_POST['c_estado']) && !empty($_POST['c_estado']) ? $this->estado = filter_input_post('c_estado') : $this->estado = null);
        (isset($_POST['c_telefone']) && !empty($_POST['c_telefone']) ? $this->telefone = filter_input_post('c_telefone') : $this->telefone = null);
        (isset($_POST['c_login']) && !empty($_POST['c_login']) ? $this->login = filter_input_post('c_login') : $this->login = null);
        (isset($_POST['c_email']) && !empty($_POST['c_email']) ? $this->email = filter_input_post('c_email') : $this->email = null);
        (isset($_POST['name_plano']) && !empty($_POST['name_plano']) ? $this->plano = filter_input(INPUT_POST, 'name_plano', FILTER_SANITIZE_NUMBER_INT) : $this->plano = null);
        (isset($_POST['c_g-recaptcha-response']) && !empty($_POST['c_g-recaptcha-response'])) ? $this->gRecaptchaResponse = $_POST['c_g-recaptcha-response'] : $this->gRecaptchaResponse = NULL;
        # Criando uma senha hash 
        $objPass = new PasswordController();
        if(isset($_POST['c_senha']) && !empty($_POST['c_senha'])) { 
            $this->senha = filter_input_post('c_senha'); 
            $this->hashSenha = $objPass->passwordHash($this->senha);
        } else{
            $this->hashSenha = null; 
        }
        # Confirma a senha
        if(isset($_POST['c_conf-senha']) && !empty($_POST['c_conf-senha'])) {
            $this->confSenha = filter_input_post('c_conf-senha');
        } else{
            $this->confSenha = null; 
        }

        # Se estiver passando dados via post cria uma data atual e um token
        if(isset($_POST)) {
            $this->dataCreate = date("Y-m-d H:i:s");
            $this->token=bin2hex(random_bytes(64));
        } else {
            $this->dataCreate = NULL;
            $this->token = NULL;
        }
    }

    # Valida formulario
    public function validado()
    {       
        # Validações 
        $this->validarFields();
        $this->valida = new ValidarController;
        $this->valida->validarCadastro($_POST);
        $this->valida->validaCpf('c_cpf');
        $this->valida->validaEmail('c_email');
        $this->valida->validaIssetEmail($this->email);
        $this->valida->validateStrongSenha($this->senha);
        $this->valida->validaConfSenha($this->senha, $this->confSenha);
        // $this->valida->validateCaptcha($this->gRecaptchaResponse);
        
        # Array com as informações do cadastro
        $arraVar = [
            "email"         => $this->email,
            "hashSenha"     =>$this->hashSenha,
            "login"         =>$this->login,
            "nome"          =>$this->nome,
            "cpf"           =>$this->cpf,
            "rg"            =>$this->rg,
            "estado_civil"  =>$this->estado_civil,
            "endereco"      =>$this->endereco,
            "bairro"        =>$this->bairro,
            "cep"           =>$this->cep,
            "cidade"        =>$this->cidade,
            "estado"        =>$this->estado,
            "telefone"      =>$this->telefone,
            "plano"         =>$this->plano,
            "date_cadastro" =>$this->dataCreate,
            "status"        =>$this->status,
            "token"         =>$this->token,
        ];

        # Validação final do formulario junto com json
        echo $this->valida->validateFinalCad($arraVar);        
    }
}