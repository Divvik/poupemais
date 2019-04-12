<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\ClassCrud;
use Src\Core\Session;
use Src\Core\GetIp;

class LoginDB extends ClassCrud
{   

    private $getIp;
    private $dateNow;

    public function __construct()
    {       
        # Parent construct() Models
        parent::__construct();
        $this->getIp = GetIp::getUserIp();
        $this->dateNow = date("Y-m-d H:i:s");
    }

    # Retorna os dados do usuário
    public function getUser($login)
    {   
        $query = $this->selectDB("*","usuarios","WHERE login = ?", array($login));
        $rows = $query->rowCount();
        
        if($rows > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $arrData=[
                "data" => $result,
                "rows" => $rows
            ];
        } else {
            return false;
        }
    }

    public function lista($id)
    {   
        $query = $this->selectDB(
            "c.nome, i.numero_investimento AS nº_investimento, 
                i.data_contratacao AS contratacao, 
                v.parcela, v.vencimento AS dt_vencimento, 
                v.valor,v.data_pagamento, 
                v.situacao, p.nome AS plano, 
                g.nome AS grupo",
            "investimentos AS i
            JOIN clientes AS c ON c.id = i.id_cliente
            JOIN planos AS p ON p.id = i.id_plano
            JOIN vencimentos AS v ON v.investimentos_id = i.id 
            JOIN grupos AS g ON g.id = i.id_grupo", "WHERE c.id = ? ORDER BY v.situacao DESC, v.vencimento ASC", array($id));
        // echo $id;
        $count = $query->rowCount();
        if($count > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } else {
            return $count;
        }
    }

    public function listaAdmin($login, $senha)
    {
        $sql = "SELECT * FROM tb_usuario WHERE login = :login AND senha = MD5(:senha)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data['email'] === 'admin@admin.com') {
                return $data;
            } else {
                throw new Exception("Usuário não cadastraado!");
            }
        }
    }

    # Conta as tentativas de acesso
    public function countAttempt()
    {
        $query = $this->selectDB("*","tentativas","where ip = ?",array($this->getIp));
        $tentativas = 0;

        while($f = $query->fetch(PDO::FETCH_ASSOC)){
            # 1200 = 20minutos caso passe esse periodo o usuario pode acessar
            if(strtotime($f["date"]) > strtotime($this->dateNow)-1200){
                $tentativas++;
            }
        }
        return $tentativas;
    }

    # Inseri as tentativas
    public function insertAttempt()
    {
        if($this->countAttempt() < 5){
            $this->insertDB("tentativas (ip,date)","?,?",array($this->getIp,$this->dateNow));
        }
    }

    # Deleta as tentativas
    public function deleteAttempt()
    {
        $this->deleteDB("tentativas","ip = ?",array($this->getIp)); 
    }
}