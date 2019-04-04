<?php

# Declarando namespace
namespace App\Controllers;

# Declarando use
use Src\Core\Controllers;
use App\Models\CadastrarDB;

# Declarando a class
class CadastroController extends Controllers
{   

    // private $cadastroDB;
    // public function __construct()
    // {
    //     parent::__construct();
    //     echo "Calcula as parcela a partir de hoje<br/>";
    //     $this->calcularParcelas(6);
    //     echo "<br/><br/>";
    //     echo "Calcula as parcela a partir de uma data qualquer<br/>";
    //     $this->calcularParcelas(6, "04/04/2019");
    // }

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
    
    public function calcularParcelas($nParcelas, $dataPrimeiraParcela = null)
    {   
        $dataVencimento = [];
        if($dataPrimeiraParcela != null){
          $dataPrimeiraParcela = explode( "/",$dataPrimeiraParcela);
          $dia = $dataPrimeiraParcela[0];
          $mes = $dataPrimeiraParcela[1];
          $ano = $dataPrimeiraParcela[2];
        } else {
          $dia = date("d");
          $mes = date("m");
          $ano = date("Y");
        }
       
        for($x = 0; $x < $nParcelas; $x++){
            $dado = date("d/m/Y",strtotime("+".$x." month",mktime(0, 0, 0,$mes,$dia,$ano)));
            array_push($dataVencimento, $dado); 
        }
        return $dataVencimento;
    }
}