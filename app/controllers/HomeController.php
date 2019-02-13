<?php

# Declarando namespace
namespace App\Controllers;

# Declarando use
use Src\Core\Controllers;

# Declarando a classe HomeController
class HomeController extends Controllers
{
    public function index()
    {   
        $this->view->render('home/index');
    }
    public function sobre()
    {
        $this->view->render('home/sobre');
    }
    public function contato()
    {
        $this->view->render('home/contato');
    }
}