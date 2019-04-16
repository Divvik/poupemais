<?php

#namespace
namespace App\Controllers;

# Use
use Src\Core\Controllers;
use Src\Core\Session;
use App\Models\LoginDB;

# Classe Admin
class SistemaController extends Controllers
{
    public function index()
    {
        $this->view->render('sistema/index');
    }
    
}
