<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\ClassCrud;

class CadastrarDB extends ClassCrud
{

    private $id;

    # Seleciona o ultimo ID para acrescentar na tabela cliente
    public function selectUltId()
    {
        $result = $this->selectDB("*","tb_usuario", "ORDER BY idUsuario DESC limit 1", array());
        $this->id = $result->fetch(PDO::FETCH_ASSOC);
        return $this->id['idUsuario'];
    }

    # Insere um usuario 
    public function insertUser($arrVar)
    {   
        $this->insertDB("tb_usuario (email,senha,login)","?,?,?",array($arrVar['email'],$arrVar['hashSenha'],$arrVar['login']));
    }

    # Insere um cliente
    public function insertCliente($arrVar, $id)
    {
        $this->insertDB("tb_cliente (nomeCliente,cpf,rg,estado_civil,endereco,bairro,cep,cidade,estado,telefone,date_cadastro,status,idUsuario)", 
            "?,?,?,?,?,?,?,?,?,?,?,?,?",
        array($arrVar['nome'],$arrVar['cpf'],$arrVar['rg'],$arrVar['estado_civil'],$arrVar['endereco'],$arrVar['bairro'],$arrVar['cep'],$arrVar['cidade'],$arrVar['estado'], 
                $arrVar['telefone'],$arrVar['date_cadastro'],$arrVar['status'],$id));
    }

    # Insere dados na tabela confirmation (serve para confirma cadastro)
    public function insertConfirmation($arrVar)
    {
        $this->insertDB("confirmation (email,token)","?,?", array($arrVar['email'], $arrVar['token']));
    }

    # Verifica se o email esta cadastrado
    public function getEmail($email)
    {   
        $query = $this->selectDB("*", "tb_usuario", "WHERE email = '{$email}'", array());
        $result = $query->rowCount();
        return $result;
    }

}