<?php

# Declarando namespace
namespace App\Controllers;

# Declarando use
use Src\Core\Controllers;
use App\Models\CadastrarDB;

# Declarando a class
class CadastroController extends Controllers
{   

    private $cadastroDB;


    public function index()
    {   
        # Instanciando cadastrarDB
        $this->cadastroDB = new CadastrarDB;
        # selecionando os planos
        $dados = $this->cadastroDB->selectPlano();
        // var_dump($dados);

        // // foreach ($dados as $row) {
        // //     foreach ($row as $linha => $value) {
        // //         echo $linha . "<br>" . $value;
        // //     }

        // }
        $this->view->render('cadastro/cadastro', ['planos' => $dados]);
    }  
}