<?php

# Declarando namespace
namespace Src\Core;

# Use
use App\Models\LoginDB;

# Declarando a class
class PasswordController
{
    private $db;

    public function __construct()
    {
        $this->db = new LoginDB;
    }

    # Cria po hash da senha para salvar no banco de dados
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    # Verifica se a senha do hash esta correto
    public function verifyHash($senha,$hashDb)
    {
        return password_verify($senha, $hashDb);
    }
}