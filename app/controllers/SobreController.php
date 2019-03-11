<?php

# Declarando namespace
namespace App\Controllers;

# Declarando use
use Src\Core\Controllers;

# Declarando a classe HomeController
class SobreController extends Controllers
{   
    public function __construct()
    {
        parent::__construct();
        $this->view->setTitle('Poupemais');
        $this->view->setDescription('Conheça mais sobre a poupemais e não perca mais tempo no seu investimento.');
        $this->view->setKeywords('poupemais, investimento, financias, aplicação');
    }
    public function index()
    {   
        $this->view->setTitle('Sobre - Poupemais');
        $this->view->render('sobre');
    }
}