<?php

# Declarando namespace
namespace App\Controllers;

# Declarando a classe HomeController
class HomeController
{
    public function index($name = '', $idade = '')
    {
        echo "Welcome! Poupemais " .''. $name .' '. $idade;
    }
}