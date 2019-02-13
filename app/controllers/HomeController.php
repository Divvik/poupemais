<?php

# Declarando namespace
namespace App\Controllers;

# Declarando use
use Src\Core\Controllers;

# Declarando a classe HomeController
class HomeController extends Controllers
{
    public function index($name = '', $idade = '')
    {   
        $this->view->render('home/index');
    }
}