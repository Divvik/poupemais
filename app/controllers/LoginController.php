<?php

# Declarando no namespace
namespace App\Controllers;

use Src\Core\Controllers;
use App\Models\LoginDB;

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
        $usuario->lista();
        
    }

}