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
    private $validaDados;
    private $erro = [];
    private $user;
    private $db;
    private $hashDB;
    private $gRecaptchaResponse;

    public function __construct()
    {
        parent::__construct();
        $this->hashDB = new PasswordController; 
        $this->db = new LoginDB;
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
            exit('Informe seu login');
        } elseif(!isset($_POST['c_password']) || empty($_POST['c_password'])) {
            exit('Informe susa senha');
        } else {
            
            $this->login = filter_input_post('c_login');
            $this->senha = filter_input_post('c_password');
            (isset($_POST['c_g-recaptcha-response']) && !empty($_POST['c_g-recaptcha-response'])) ? $this->gRecaptchaResponse = $_POST['c_g-recaptcha-response'] : $this->gRecaptchaResponse = NULL;
            
            if(is_array($this->db->getUser($this->login))){
                
                
                $user = $this->db->getUser($this->login);   
                if($this->hashDB->verifyHash($this->senha, $user["senha"])){
                    Session::init();
                    Session::set('idUsuario', $user['idUsuario']);
                    Session::set('login', $user['login']);
                } else {
                    $this->validateCaptcha($this->gRecaptchaResponse);
                    exit("Usuario e ou senha invalidos!");   
                }
            } else {
                exit($this->db->getUser($this->login));
            }
            
        }
    }
    
    public function validateCaptcha($captcha, $score=0.5)
    {   
        $retorno = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRETKEY."&response={$captcha}");
        $response = json_decode($retorno);
        if($response->success == true && $response->score >= $score) {
        } else {
            exit("Captcha Inválido! Atualize a página e tente novamente.");
        }
    }
    public function logout()
    {   
        Session::init();
        if(isset($_SESSION['idUsuario'])) {
            Session::destroy();
            header('location: ../login');
            exit();
        }
    }
}