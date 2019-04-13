<?php

# Declarando no namespace
namespace App\Controllers;

# Use
use Src\Core\Controllers;
use App\Controllers\ValidarController;
use App\Models\LoginDB;
use Src\Core\Session;
use Src\Core\PasswordController;

# Declarando a classe Sobre
class LoginController extends Controllers
{   
    private $login;
    private $senha;
    private $erro = [];
    private $success = [];
    private $user;
    private $db;
    private $valida;
    private $hashDB;
    private $gRecaptchaResponse;
    private $tentativas;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->hashDB = new PasswordController; 
        $this->db = new LoginDB();
        $this->valida = new ValidarController;
        $this->session = new Session();
        
        $this->view->setTitle('Login - Poupemais');
        $this->view->setDescription('Conheça mais sobre a poupemais e não perca mais tempo no seu investimento.');
        $this->view->setKeywords('poupemais, investimento, financias, aplicação');
    }
    public function index()
    {
        $this->view->render('login/index'); 
    }
    public function getErro()
    {
        return $this->erro;
    }
    public function setErro($erro)
    {
        array_push($this->erro, $erro);
    }
    public function validaUsers()
    {       
        if(!isset($_POST['c_login']) || empty($_POST['c_login'])) {
            $this->setErro('Informe seu login');

        } elseif(!isset($_POST['c_password']) || empty($_POST['c_password'])) {
            $this->setErro('Informe sua senha');
        } else {
            $this->login = filter_input_post('c_login');
            $this->senha = filter_input_post('c_password');
            (isset($_POST['c_g-recaptcha-response']) && !empty($_POST['c_g-recaptcha-response'])) ? $this->gRecaptchaResponse = $_POST['c_g-recaptcha-response'] : $this->gRecaptchaResponse = NULL;
            
            if(is_array($this->db->getUser($this->login))){
                $user = $this->db->getUser($this->login);
                if($this->hashDB->verifyHash($this->senha, $user["data"]["senha"])){
                    $this->success = 'Login efetuado com sucesso!'; 
                } else {
                    $this->setErro("Usuario e ou senha invalidos!");   
                }
            } else {
                // $this->validateCaptcha($this->gRecaptchaResponse);
                $this->setErro('Usuario não existe!');  
            }
        }
        
        $this->valida->validateUserActive($this->db, $this->login, $this);
        $this->validaTentativasLogin();
        $this->validateFinalLogin($this->login);
        echo $this->validaErros();
    }
    
    public function validateCaptcha($captcha, $score=0.5)
    {   
        $retorno = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRETKEY."&response={$captcha}");
        $response = json_decode($retorno);
        if($response->success == true && $response->score >= $score) {
        } else {
            $this->setErro('Captcha Inválido! Atualize a página e tente novamente.');
        }
    }

    # Validação das tentativas
    public function validaTentativasLogin()
    {
        if($this->db->countAttempt() >= 5){
            $this->tentativas = true;
            $this->setErro('Você realizou mais de 5 tentativas.');
            return false;
        } else {
            $this->tentativas = false;
            return true;
        }
    }

    # Validação final do login
    public function validateFinalLogin($login)
    {
        if(count($this->getErro()) > 0){
            $this->db->insertAttempt(); 
        } else {
            $this->db->deleteAttempt();
            return $this->session->setSession($login);
        }
    }

    # Validação de erros
    public function validaErros()
    {
        if(count($this->getErro()) > 0){
            $arrReponse=[
                "retorno"=>"erro",
                "erros"=>$this->getErro(),
                "tentativas" => $this->tentativas
            ];
        } else 
            $arrReponse=[
                "retorno"=>"success",
                "success"=> $this->success,
                "tentativas" => $this->tentativas
            ];
        return json_encode($arrReponse);
    }

    
}