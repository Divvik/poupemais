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
        $this->insertDB("usuarios (login, senha, email,data_cadastro, status)","?,?,?,?,?",array($arrVar['login']),$arrVar['hashSenha'],$arrVar['email'], $array['data_cad'], 'confirmar');
    }
    
    # 2º Inserção banco de dados
    # Insere um cliente
    public function insertCliente($arrVar)
    {
        $result = $this->selectDB("*","usuarios", "ORDER BY id DESC limit 1", array());
        $dado = $result->fetch(PDO::FETCH_ASSOC);
        $idUsuario = $dado['id'];

        $this->insertDB("clientes (nome,cpf,rg,estado_civil,telefone,endereco,bairro,cep,cidade,estado,id_usuario)", 
            "?,?,?,?,?,?,?,?,?,?,?,?,?",
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
    public function insertInvest()
    {   
        # Seleciona o ultimo id do cliente
        $result = $this->selectDB("*","clientes", "ORDER BY id DESC limit 1", array());
        $cliente = $result->fetch(PDO::FETCH_ASSOC);
        $idCliente = $cliente['id'];

        # Seleciona o ultimo id do plano
        $result = $this->selectDB("*","planos", "ORDER BY id DESC limit 1", array());
        $plano = $result->fetch(PDO::FETCH_ASSOC);
        $idPlano = $plano['id'];

        $query = $this->selectDB("id, nome","grupos","", array());
        $row = $query->rowCount();
        
        if($row < 10) {
            $grupo = $query->fecthAll(PDO::FETCH_ASSOC);
            $idGrupo = $grupo['id'];
            return $idGrupo;
        } else {
            return false;
        }

        # Seleciona o ultimo numero do investimento
        $result = $this->selectDB("*","investimentos", "ORDER BY id DESC limit 1", array());
        $investimento = $result->fetch(PDO::FETCH_ASSOC);
        $numInvest['numero_investimento'] + 1;

        $this->insertDB("investimentos (numero_investimento,data_contratacao,id_cliente,id_plano,id_grupo)", 
            "?,?,?,?,?", array(
                $numInvest,
                $this->getDataAtual(),
                $idCliente,
                $idPlano,
                $idGrupo
            ));
    }

    # 4º Inserção banco de dados
    # Insere vencimentos
    public function insertVencimentos($arr)
    {   
        $this->insertDB("vencimentos (parcela,vencimento,valor,situacao,investimentos_id)",
            "?,?,?,?,?",
            array(
            )
        );
    }
    
    # Insere dados na tabela confirmation (serve para confirma cadastro)
    public function insertConfirmation($arrVar)
    {
        $this->insertDB("confirmation (email,token)","?,?", array($arrVar['email'], $arrVar['token']));
    }

    # Verifica se o email esta cadastrado
    public function getEmail($email)
    {   
        $query = $this->selectDB("*", "usuarios", "WHERE email = '{$email}'", array());
        $result = $query->rowCount();
        return $result;
    }
    
}