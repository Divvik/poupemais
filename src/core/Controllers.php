<?php

# Declarando namespace
namespace Src\Core;
use Src\Core\Views;


# Declarando classe de suporte para o controllers
class Controllers
{   
    
    public function __construct()
    {
        $this->view = new Views();
    }

}