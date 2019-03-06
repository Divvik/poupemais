<?php

#namespace
namespace App\Controllers;

# Use
use Src\Core\Controllers;
use Src\Core\Session;
use App\Models\LoginDB;

# Classe Admin
class AdminController extends Controllers
{
    public function __construct()
    {   
        parent::__construct();
        Session::init();
        $this->view->setTitle('Admin');
    }

    public function index()
    {
        $this->view->render('admin/index');
    }

    public function validaAdmin()
    {
        if(file_exists(MODELS . 'LoginDB.php')) {

            $login = filter_input_post('c_login');
            $pass = filter_input_post('c_password');
            
            $dado = new LoginDB();
            $admin = $dado->listaAdmin($login, $pass);       
            
            Session::set('idUsuario', $admin['idUsuario']);
            Session::set('login', $admin['login']);
            header('location: ../admin/dashboard');
            exit();
        } else {
            echo 'O arquivo não existe'; 
            exit();
        }
    }

    public function dashboard()
    {
        $this->view->render('admin/dashboard');
    }

    public function cadastrar()
    {   
        $this->view->render('admin/index');
    }
}
