<?php

# Declarando namespace
namespace Src\Core;

# Classe para renderizar as views
class Views
{
    # Redenriza as views
    public function render($viewName, $data=[])
    {
        require_once VIEWS . $viewName . '.phtml';
    }
}