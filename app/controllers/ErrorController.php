<?php

# Declarando namespace
namespace App\Controllers;

# Declarando use
use Src\Core\Controllers;

# Declarando Class Error
class ErrorController extends Controllers
{

    # Declarando metodo construct
    public function index()
    {   
        $this->view->render('404Error/index');
    }
}