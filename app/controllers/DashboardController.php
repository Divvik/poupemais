<?php

# namespace
namespace App\Controllers;

# use
use Src\Core\Controllers;
use Src\Core\Session;

# Classe DashboardController
class DashboardController extends Controllers
{
    public function __construct()
    {   
        parent::__construct();
        
        Session::init();
        $logged = Session::get('loggedIn');
       
        if($logged == false) {
            Session::destroy();
            header('location: ../login');
            exit; 
        } 
    }
    
    public function index()
    {   
        $this->view->render('dashboard/index');
    }
}