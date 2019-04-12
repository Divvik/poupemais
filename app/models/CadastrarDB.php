<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\ClassCrud;

class CadastrarDB extends ClassCrud
{
    private $dataCad;
    private $dataAtual;

    # Data Cadastro 
    public function getDateCad()
    {
        return $this->dataCad = Date('Y-m-d-H:m:i');
    }
    # Data Atual
    public function getDataAtual()
    {
        return $this->dataAtual = Date('Y-m-d');
    }
    
    # Select plano
    public function selectPlano()
    {
        $plano = $this->selectDB("*","planos","",array());
        $result = $plano->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    # 1° Inserção banco de dados
    # Insere um usuario 
    public function insertUser($arrVar)
    {   
        $this->insertDB("usuarios (login, senha, email,data_cadastro, status)",
            "?,?,?,?,?",
            array(
                $arrVar['login'],
                $arrVar['hashSenha'],
                $arrVar['email'], 
                $arrVar['date_cadastro'], 
                'confirmar'
            ));
    }
    
    # 2º Inserção banco de dados
    # Insere um cliente
    public function insertCliente($arrVar)
    {   
        
        $result = $this->selectDB("*","usuarios", "ORDER BY id DESC limit 1", array());
        $dado = $result->fetch(PDO::FETCH_ASSOC);
        $idUsuario = $dado['id'];

        $this->insertDB("clientes (nome,cpf,rg,estado_civil,telefone,endereco,bairro,cep,cidade,estado,id_usuario)", 
            "?,?,?,?,?,?,?,?,?,?,?",
        array(
            $arrVar['nome'],
            $arrVar['cpf'],
            $arrVar['rg'],
            $arrVar['estado_civil'],
            $arrVar['telefone'],
            $arrVar['endereco'],
            $arrVar['bairro'],
            $arrVar['cep'],
            $arrVar['cidade'],
            $arrVar['estado'], 
            $idUsuario)
        );
    }

    # 3º Inserção banco de dados
    # Insere investimentos
    public function insertInvest($plano)
    {   
        
        # Seleciona o ultimo id do cliente
        $result = $this->selectDB("*","clientes", "ORDER BY id DESC limit 1", array());
        $cliente = $result->fetch(PDO::FETCH_ASSOC);
        $idCliente = $cliente['id'];
                
        $query = $this->selectDB("*","grupos","", array());
        $row = $query->rowCount();
        
        $grupos = $this->selectDB("*","grupos", "ORDER BY id DESC limit 1", array());
        $grupo = $grupos->fetch(PDO::FETCH_ASSOC);
        $idGrupo = $grupo['id'];
    
        # Seleciona o ultimo numero do investimento
        $result = $this->selectDB("*","investimentos", "ORDER BY id DESC limit 1", array());
        $investimento = $result->fetch(PDO::FETCH_ASSOC);
        $numInvest = $investimento['numero_investimento'] + 1;

        
        $arrayDado = ["data_atual" => $this->getDataAtual()];

        $this->insertDB("investimentos (numero_investimento,data_contratacao,id_cliente,id_plano,id_grupo)", 
            "?,?,?,?,?", array(
                $numInvest,
                $this->getDateCad(),
                $idCliente,
                $plano['plano'],
                $idGrupo
            ));
    }

    # 4º Inserção banco de dados
    # Insere vencimentos
    public function insertVencimentos($datas,$planos)
    {   
        # Seleciona o ultimo id da tabela investimentos
        $result = $this->selectDB("*","investimentos", "ORDER BY id DESC limit 1", array());
        $dado = $result->fetch(PDO::FETCH_ASSOC);
        $idInvestimento = $dado['id'];
        
        # Retorna do formulario o plano
        $plano = $planos['plano'];
        
        # Retorna o valor conforme a escolha do plano
        $valor = 0;

        if($plano == 1 || $plano == 5) {
            $valor = 50.00;
        } elseif($plano == 2 || $plano == 6) {
            $valor = 100.00;
        } elseif($plano == 3 || $plano == 7) {
            $valor = 150.00;
        } elseif($plano == 4 || $plano == 8) {
            $valor = 200.00;
        } else {
            return false;
        }
        
        # Seleciona as parcelas conforme o plano escolhido
        $parcela = 0;

        foreach ($datas as $vencimento) {
            $parcela++;
            $this->insertDB("vencimentos (parcela,vencimento,valor,situacao,investimentos_id)",
                "?,?,?,?,?",
                array(
                    $parcela,
                    $vencimento, 
                    $valor,
                    "aberto",
                    $idInvestimento,
                )
            );
        }
    }
    
    # Insere dados na tabela confirmation (serve para confirma cadastro)
    public function insertConfirmation($arrVar)
    {
    
        $this->insertDB("confirmation (email,token)","?,?", array(
            $arrVar['email'], 
            $arrVar['token']
            )
        ); 
    }

    # Verifica se o email esta cadastrado
    public function getEmail($email)
    {   
        $query = $this->selectDB("*", "usuarios", "WHERE email = ?", array($email));
        $result = $query->rowCount();
        return $result;
    }
    
}