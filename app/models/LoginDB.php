<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\Models;
use Src\Core\Session;

class LoginDB extends Models
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select($login,$pass)
    {           
        $sql = "SELECT * FROM tb_usuario WHERE login = :login AND senha = MD5(:senha)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $pass);
        $stmt->execute();

        $count = $stmt->rowCount();
        
        if($count > 0) {
            return $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            //Show error!
            header('location: ../login');
        }
    }

    public function lista($id)
    {   
        $sql = "SELECT c.nomeCliente, c.cpf, i.vencimento, i.situacao, pla.nomePlano, pla.valorPlano 
            FROM tb_cliente AS c 
            JOIN tb_usuario_invest AS i ON c.idCliente = i.idCliente 
            JOIN tb_planos AS pla ON pla.idPlano = i.idPlano 
            WHERE c.idCliente = :id  ORDER BY i.vencimento ASC; 
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $count = $stmt->rowCount();
        
        if($count > 0) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
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
}