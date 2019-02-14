<?php

# Declarando no namespace
namespace App\Controllers;
use Src\Core\Controllers;

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

}