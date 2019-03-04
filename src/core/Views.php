<?php

# Declarando namespace
namespace Src\Core;
use Exception;
# Classe para renderizar as views
class Views
{
    private $title = 'home';
    private $keywords = '';
    private $description = '';

    # Redenriza as views
    public function render($viewName, $data=[])
    {   
        if(file_exists(VIEWS . $viewName . '.php')) {
            require_once VIEWS . $viewName . '.php';
        } else {
            throw new Exception("Arquvio não encontrado!");
        }
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

}