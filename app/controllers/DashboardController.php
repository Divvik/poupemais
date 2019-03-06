<?php

# namespace
namespace App\Controllers;

# use
use Src\Core\Controllers;
use Src\Core\Session;
use App\Models\LoginDB;

# Classe DashboardController
class DashboardController extends Controllers
{
    public function __construct()
    {   
        parent::__construct();
        Session::init();
        $this->view->setTitle('Poupemais');
        $this->view->setDescription('Conheça mais sobre a poupemais e não perca mais tempo no seu investimento.');
        $this->view->setKeywords('poupemais, investimento, financias, aplicação');
    }
    
    public function index()
    {   
        if(!isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])) {
            Session::destroy();
            header('location:' . DIRPAGE . '/login');
            exit();
        } else {
            $dados = new LoginDB();
            $usuario = $dados->lista(Session::get('idUsuario'));
            $this->view->render('dashboard/index',['usuario' => $usuario]);
        }
    }
}