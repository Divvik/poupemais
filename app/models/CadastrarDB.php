<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\Models;

class CadastrarDB extends Models
{

    public function insert($email,$senha,$login,$nome,$endereco,$cpf,$cidade,$estado,$telefone)
    {           
        $sqlUsuario = "INSERT INTO tb_usuario (email,senha,login) 
            VALUES(:email,md5(:senha),:login)";
        $stmtUser = $this->db->prepare($sqlUsuario);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->bindParam(':senha', $senha);
        $stmtUser->bindParam(':login', $login);
        $stmtUser->execute();

        $sqlIdUsario = "SELECT * FROM tb_usuario ORDER BY idUsuario DESC limit 1";
        $stmtIdUsuario = $this->db->prepare($sqlIdUsario); 
        $stmtIdUsuario->execute();
        $result = $stmtIdUsuario->fetch(PDO::FETCH_ASSOC);
        $idUsuario = $result['idUsuario'];

        $sqlCliente = 
        "INSERT INTO tb_cliente (nomeCliente,endereco,cpf,cidade,estado,telefone,idUsuario) 
            VALUES(:nome,:endereco,:cpf,:cidade,:estado,:telefone,:idUsuario)";
        $stmt = $this->db->prepare($sqlCliente);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
    }   
}