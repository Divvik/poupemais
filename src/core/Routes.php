<?php

# Declarando a namespace
namespace Src\Core;


# Declarando a class Routes para capturar as rotas amigaveis
class Routes
{   
    # Declarando as variaveis
    protected $controller = 'HomeController';
    protected $action  = 'index';
    protected $param = [];

    # Declarando o construct da classe Routes
    public function __construct()
    {
        $this->parseUrl();

        if(file_exists(CONTROLLERS . $this->controller .'.php')) {
             $controller = "App\\Controllers\\" . $this->controller;
             $this->controller = new $controller();
             
             if(method_exists($this->controller, $this->action)) {
                call_user_func_array([$this->controller, $this->action],$this->param);
            }
        } else {
            $error = "App\\Controllers\\ErrorController";
            $controller = new $error;
            $controller->index();
        }
    }

    # Capturando a url
    protected function parseUrl()
    {   
        $url = explode('/', rtrim($_GET['url'],'/'));

        if(isset($url[0]) && $url[0] != '') {
            $this->controller = ucfirst($url[0]) . 'Controller';
        } 

        if(isset($url[1])) {
            $this->action = $url[1];
        } 

        unset($url[0], $url[1]);

        $this->param = !empty($url) ? array_values($url) : [];
    }
}