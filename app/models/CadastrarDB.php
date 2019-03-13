<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\Models;

class CadastrarDB extends Models
{

    public function insert($email,$senha,$login,$nome,$cpf,$rg,$estado_civil,$endereco,$bairro,$cep,$cidade,$estado,$telefone,$date_cadastro,$status_cli,$token)
    {           
        
        $sqlUsuario = "INSERT INTO tb_usuario (email,senha,login) 
            VALUES(:email,:senha,:login)";
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
        "INSERT INTO tb_cliente (nomeCliente,cpf,rg,estado_civil,endereco,bairro,cep,cidade,estado,telefone,date_cadastro,status,idUsuario) 
                          VALUES(:nome,:cpf,:rg,:estado_civil,:endereco,:bairro,:cep,:cidade,:estado,:telefone,:date_cadastro,:status_cli,:idUsuario)";
        $stmt = $this->db->prepare($sqlCliente);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':rg', $rg);
        $stmt->bindParam(':estado_civil', $estado_civil);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':date_cadastro', $date_cadastro);
        $stmt->bindParam(':status_cli', $status_cli);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $sqlConfirmation = 
        "INSERT INTO confirmation (email,token) VALUES (:email,:token)";
        $stmt = $this->db->prepare($sqlConfirmation);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute(); 
    }   

    # Verifica se o email esta cadastrado
    public function getEmail($email)
    {
        $slq = "SELECT * FROM tb_usuario WHERE email = :email";
        $stmt = $this->db->prepare($slq);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $resultado = $stmt->rowCount();
        return $resultado;
    }

}