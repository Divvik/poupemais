<?php

# Declarando namespace
namespace Src\Core;
use Exception;
# Classe para renderizar as views
class Views
{
    # Redenriza as views
    public function render($viewName, $data=[])
    {   
        if(file_exists(VIEWS . $viewName . '.php')) {
            extract($data);
            require_once VIEWS . $viewName . '.php';
        } else {
            throw new Exception("Arquvio não encontrado!");
        }
    }
}