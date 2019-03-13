<?php

# Declarando namespace
namespace App\Controllers;

# Declarando a class
class PasswordController
{
    # Cria po hash da senha para salvar no banco de dados
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}