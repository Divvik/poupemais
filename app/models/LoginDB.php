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

    public function select($login, $pass)
    {           
        $sql = "SELECT * FROM usuario WHERE login = :login AND senha = MD5(:senha)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $pass);
        $stmt->execute();

        $count = $stmt->rowCount();
        
        if($count > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            Session::init();
            Session::set('id', $data['id']);
            Session::set('login', $data['login']);
        } else {
            //Show error!
            header('location: ../login');
        }
    }

    public function lista()
    {   

        $sql = "SELECT * FROM usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $count = $stmt->rowCount();
        
        if($count > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }
}