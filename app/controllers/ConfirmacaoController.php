<?php

namespace App\Controllers;

class ConfirmacaoController
{
    public function confirmacao($nome, $token)
    {
        echo $nome . "<br>";
        echo $token . "<br>";
    }
}