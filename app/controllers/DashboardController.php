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
    }
    
    public function index()
    {   
        if(!isset($_SESSION['id']) && empty($_SESSION['id'])) {
            Session::destroy();
            header('location:' . DIRPAGE . '/login');
            exit();
        } else {
            $dados = new LoginDB();
            $usuario = $dados->lista();
            $this->view->render('dashboard/index',['usuario' => $usuario]);
        }
    }
}