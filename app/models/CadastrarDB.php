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
    private $idUsuario;
    private $idCliente;  
    private $idPlano;
    private $idGrupo;

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

    # 1° Inserção banco de dados
    # Insere um usuario 
    public function insertUser($arrVar)
    {   
        $this->insertDB("usuarios (login, senha, email,data_cadastro, status)","?,?,?,?,?",array($arrVar['login']),$arrVar['hashSenha'],$arrVar['email'], $array['data_cad'], 'confirmar');
    }
    # Seleciona o ultimo ID para acrescentar na tabela cliente
    public function selectUltId()
    {
        $result = $this->selectDB("*","usuarios", "ORDER BY id DESC limit 1", array());
        $id = $result->fetch(PDO::FETCH_ASSOC);
        return $this->idUsuario = $id['id'];
    }

    # 2º Inserção banco de dados
    # Insere um cliente
    public function insertCliente($arrVar)
    {
        $this->insertDB("clientes (nome,cpf,rg,estado_civil,telefone,endereco,bairro,cep,cidade,estado,id_usuario)", 
            "?,?,?,?,?,?,?,?,?,?,?,?,?",
        array($arrVar['nome'],$arrVar['cpf'],$arrVar['rg'],$arrVar['estado_civil'],$arrVar['telefone'],$arrVar['endereco'],$arrVar['bairro'],$arrVar['cep'],$arrVar['cidade'],$arrVar['estado'], $this->idUsuario));
    }

    # 3º Inserção banco de dados
    # Insere um investimento
    # Seleciona tabela plano
    public function selectPlano()
    {
        $query = $this->selectDB("id, nome","planos","", array());
        $plano = $query->fetchAll(PDO::FETCH_ASSOC);
        return $plano;
    }
    # Seleciona o ultimo id do plano
    public function selectUltIdPlano()
    {
        $result = $this->selectDB("*","planos", "ORDER BY id DESC limit 1", array());
        $id = $result->fetch(PDO::FETCH_ASSOC);
        return $this->idPlano = $id['id'];
    }
    # Seleciona o ultimo usuario
    public function selectUltIdCliente()
    {
        $result = $this->selectDB("*","clientes", "ORDER BY id DESC limit 1", array());
        $id = $result->fetch(PDO::FETCH_ASSOC);
        return $this->idCliente = $id['id'];
    }
    # Seleciona tabela grupos
    public function selectGrupos()
    {
        $query = $this->selectDB("id, nome","grupos","", array());
        $row = $query->rowCount();
        
        if($row < 10) {
            $grupo = $query->fecthAll(PDO::FETCH_ASSOC);
            $this->idGrupo = $grupo['id'];
            return $this->idGrupo;
        }
        return false;
    }
    # Select numero investimento
    public function selectNumInvest()
    {
        $result = $this->selectDB("*","investimentos", "ORDER BY id DESC limit 1", array());
        $id = $result->fetch(PDO::FETCH_ASSOC);
        return $this->id = $id['id'] + 1;
    }
    # Insere investimentos
    public function insertInvest()
    {
        $this->insertDB("investimentos (numero_investimento,data_contratacao,id_cliente,id_plano,id_grupo)", 
            "?,?,?,?,?", array(
                $this->selectNumInvest(),
                $this->getDataAtual(),
                $this->idCliente,
                $this->idPlano,
                $this->idGrupo
            ));
    }
    # 4º Inserção banco de dados
    # Insere vencimentos
    public function insertVencimentos($arr,)
    {   
        $this->insertDB("vencimentos (parcela,vencimento,valor,situacao,investimentos_id)",
            "?,?,?,?,?",
            if()
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