<?php 

# namespace
namespace App\Models;

# use
use Src\Core\Models;
use Src\Core\Session;

class LoginDB extends Models
{
    public function __construct()
    {
        parent::__construct();
    }

    public function lista()
    {   

        $sql = "SELECT idUsuario FROM usuario WHERE nome = :nome AND senha = MD5(:senha)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
           ':nome' => $_POST['c_login'],
           ':senha' => $_POST['c_password'] 
        ));

        //$data = $stmt->fetchAll();
        $count = $stmt->rowCount();

        if($count > 0) {
            // login
            Session::init();
            Session::set('loggedIn', true);
            header('location: ../dashboard');
        } else {
            // Show error!
            header('location: ../login');
        }
    }
}