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
    public function index()
    {
        $this->view->render('login/index'); 
    }

    public function cadastrar()
    {
        $this->view->render('login/cadastrar');

    }
    
    public function validaUsers()
    {
        $usuario = new LoginDB;
        echo $usuario->lista();        
    }

    public function logout()
    {   
        Session::init();
        if(isset($_SESSION['id'])) {
            Session::destroy();
            header('location: ../login');
            exit();
        }
    }

}