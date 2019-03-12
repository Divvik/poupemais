<?php

# Declarando no namespace
namespace App\Controllers;

# Use
use Src\Core\Controllers;
use App\Models\LoginDB;
use Src\Core\Session;

# Declarando a classe Sobre
class LoginController extends Controllers
{   
    public function __construct()
    {
     parent::__construct();
     $this->view->setTitle('Login - Poupemais');
     $this->view->setDescription('Conheça mais sobre a poupemais e não perca mais tempo no seu investimento.');
     $this->view->setKeywords('poupemais, investimento, financias, aplicação');
    }
    public function index()
    {
        $this->view->render('login/index'); 
    }

    public function validaUsers()
    {   
        if(file_exists(MODELS . 'LoginDB.php')) {

            $login = filter_input_post('c_login');
            $pass = filter_input_post('c_password');

            $data = new LoginDB(); 
            $user = $data->select($login, $pass);
           
            Session::init();
            Session::set('idUsuario', $user['idUsuario']);
            Session::set('login', $user['login']);
            header('location: ../dashboard');
            exit();
        } else {
            echo 'O arquivo não existe'; 
            exit();
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

    public function cadastrar()
    {
        $this->view->render('login/cadastrar');
    }
}