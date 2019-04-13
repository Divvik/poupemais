<?php

# namescpace
namespace Src\Core;

# Use
use App\Models\LoginDB;
use Src\Core\GetIp;

# class Session
class Session
{   
    private $login;
    private $timeSession = 1200; // 20 minutos 
    private $timeCanary = 300; // 5 minutos

    public function __construct()
    {
        if(session_id() == '') {
            ini_set("session.save_handler","files");
            ini_set("session.use_cookies",1);
            ini_set("session.use_only_cookies",1);
            ini_set("session.cookie_domain",DOMAIN);
            ini_set("session.cookie_httponly",1);
            if(DOMAIN != "localhost"){
                ini_set("session.cookie_secure",1);
            } 
            /* Criptografia das nossas sessions */
            ini_set("session.entropy_length",512);
            ini_set("session.entropy_file","/dev/urandom");
            ini_set("session.hash_function","sha256");
            ini_set("session.hash_bits_per_character",5);
            session_start();
        }
        $this->login = new LoginDB();
    }

    # Protege Contra roubo de sessão
    public function setSessionCanary($par = null)
    {
        session_regenerate_id(true);
        if($par == null) {
            $_SESSION['canary'] = [
                "birth" => time(),
                "IP" => GetIp::getUserIp(),
            ];
        } else {
            $_SESSION['canary']['birth'] = time();
        }
    }

    # Verifica a integridade da sessão
    public function verifyIdSession()
    {
        if(!isset($_SESSION['canary'])) {
            $this->setSessionCanary();
        }

        if($_SESSION['canary']['IP'] !== GetIp::getUserIp()) {
            $this->destructSession();
            $this->setSessionCanary();
        }

        if($_SESSION['canary']['birth'] < time() - $this->timeCanary) {
            $this->setSessionCanary("time");
        }
    }

    # Setar as sessões no nosso sistema
    public function setSession($login)
    {
        $this->verifyIdSession();
        $_SESSION['login'] = true;
        $_SESSION['time'] = time();
        $_SESSION['name'] = $this->login->getUser($login)['data']['login'];
        $_SESSION['email'] = $this->login->getUser($login)['data']['email'];
        return $_SESSION;
    }

    # Validar as páginas internas do sistema
    public function verifyInsideSession()
    {
        $this->verifyIdSession();
        if(!isset($_SESSION['login']) || !isset($_SESSION['canary'])) {
            $this->destructSession();
        } else {
            if($_SESSION['time'] >= time() - $this->timeSession){
                $_SESSION['time'] = time();
            } else {
                $this->destructSession();
                echo "<scritp>alert('Sua sessão expirou. Faça login novamente!</script>";
            }
        }
    }

    # Destruir a session existente
    public function destructSession()
    {
        foreach (array_keys($_SESSION) as $key) {
            unset($_SESSION[$key]); 
        }
    }
}