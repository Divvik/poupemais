<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\ClassCrud;
use Src\Core\Session;

class LoginDB extends ClassCrud
{
    # Retorna os dados do usuário
    public function getUser($login)
    {
        $query = $this->selectDB("idUsuario,login,senha","tb_usuario", "WHERE login = ?", array($login));
        
        $rows = $query->rowCount();

        if($rows > 0) {
            return  $data = $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return "Usuário não existe!";
        }
    }

    public function lista($id)
    {   
        
    
        $query = $this->selectDB(
            "c.nomeCliente, c.cpf, i.vencimento, i.situacao, pla.nomePlano, pla.valorPlano, g.nomeGrupo", 

            "tb_cliente AS c JOIN tb_usuario_invest AS i ON c.idCliente = i.idCliente 

            JOIN tb_planos AS pla ON pla.idPlano = i.idPlano 

            JOIN tb_grupos AS g ON i.idGrupo = g.idGrupo",

            "WHERE c.idCliente = ? ORDER BY i.vencimento ASC", array($id));
    
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
}