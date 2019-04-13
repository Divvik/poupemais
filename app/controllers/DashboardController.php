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
    private $session;
    private $dados;

    public function __construct()
    {   
        parent::__construct();
        $this->dados = new LoginDB();
        $this->session = new Session();
        $this->view->setTitle('Poupemais');
        $this->view->setDescription('Conheça mais sobre a poupemais e não perca mais tempo no seu investimento.');
        $this->view->setKeywords('poupemais, investimento, financias, aplicação');
    }
    
    public function index()
    {   
        if(!isset($_SESSION['login']) && empty($_SESSION['login'])) {
            $this->session->destructSession();
            echo "<script>alert('Você não tem acesso a esta area efetue um login e tente novamente!')
                    window.location.href='". DIRPAGE ."/login';
                </script>";
            exit();
        } else {
            $usuario = $this->dados->lista($_SESSION['name']);
            $this->view->render('dashboard/index',['usuario' => $usuario]);
        }
    }

    public function logout()
    {
        if(isset($_SESSION['login']) && !empty($_SESSION['login'])) {
            $this->session->destructSession();
            echo "<script>
                    alert('Logout efetuado com sucesso!')
                    window.location.href = '". DIRPAGE ."/login';
                </script>";
        }
    }
}