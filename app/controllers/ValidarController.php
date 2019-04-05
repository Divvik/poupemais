<?php
# Namespace
namespace App\Controllers;

# Use
use App\Models\CadastrarDB;
// use Src\Core\ClassCrud;
// use Src\Core\PasswordController;
use ZxcvbnPhp\Zxcvbn;
// use PDO;



# Classe Cadastrar
class ValidarController
{   
    private $erro = [];
    private $cadastro;    

    # Erros
    private $erroEmail = NULL;
    private $erroCPF = NULL;
    private $erroStrongSenha = NULL;
    private $erroConfSenha = NULL;

    // public function __construct()
    // {   


        // # Validações 
        // $this->validarCadastro($_POST);
        // $this->validarFields();
        // $this->validaCpf('c_cpf');
        // $this->validaEmail('c_email');
        // $this->validaIssetEmail($this->email);
        // $this->validateStrongSenha($this->senha);
        // $this->validaConfSenha($this->senha, $this->confSenha);
        // $this->validateCaptcha($this->gRecaptchaResponse);

        // # Validação final do formulario junto com json
        // echo $this->validateFinalCad(); 

        // # Dados enviado para o banco de dados
        // $this->cadastro->insertUser($arraVar);
        // $this->cadastro->insertCliente($arraVar,$this->cadastro->selectUltId());
        // $this->cadastro->insertConfirmation($arraVar);
        
    // }
    
    # Obtem um erro
    public function getErro()
    {
        return $this->erro;
    }

    public function setErro($erro)
    {
        array_push($this->erro, $erro);
    }

    # Valida se todos os campos desejados foram preenchidos
    public function validarCadastro($par)
    {
        $i = 0;

        foreach ($par as $key => $value) {
            if(empty($value)) {
                $i++;
            }
        }
        
        if($i == 0) {
            echo "OK";
            // return true;
        } else {
            $this->setErro('Preencha todos os dados!');
            echo 'erro';
            // return false;
        }
    }

    # Validação de email
    public function validaEmail($c_email)
    {
        if(isset($_POST[$c_email]) && !empty($_POST[$c_email])){

            $email = filter_input(INPUT_POST, $c_email, FILTER_VALIDATE_EMAIL);
            
            if(!$email) {
                $this->email = NULL;
                $this->erroEmail = "Email inválido!";
                return false;
            } else {
                return $email;
            }
        }
    }

    #Valida se email existe no banco de dados
    public function validaIssetEmail($email)
    {   
        # Instancia da Class CadastrarDB
        $this->cadastro = new CadastrarDB;
        $b = $this->cadastro->getEmail($email);
        
        if($email != NULL) {
            if($b > 0) {
                $this->erroEmail = "Email já cadastrado!";
                return false;
            } else {
                return true;
            }
        } else {
            $this->setErro('Informe o seu email!');
        }
        
    }

    # Valida CPF
    public function validaCpf($c_cpf)
    {
        if(isset($_POST[$c_cpf]) && !empty($_POST[$c_cpf])){

            $cpf = filter_input(INPUT_POST, $c_cpf, FILTER_SANITIZE_SPECIAL_CHARS);
            // Extrai somente os números
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
            
            // Verifica se foi informado todos os digitos corretamente
            if (strlen($cpf) != 11) {
                $this->erroCPF = "Digite 11 números do CPF!";
                return false;
            }
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                $this->erroCPF = "CPF não aceita números sequências!";
                return false;
            }
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $this->erroCPF = "CPF Inválido!";
                    return false;
                }
            }
            $this->cpf = $cpf;
        } else {
            $this->cpf = NULL;
        }
    }

    # Verifica se a senha é igual a confirmação de senha
    public function validaConfSenha($senha, $confSenha)
    {
        if($senha === $confSenha){
            return true;
        } else {
            $this->erroConfSenha = "A Confirmação de senha está diferente da senha";
            return false;
        }
    }

    # Verifica a força da senha
    public function validateStrongSenha($senha, $par=null)
    {   
        // Referencia https://github.com/bjeavons/zxcvbn-php
        $zxcvbn = new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($senha);

        if($strength['score'] >= 3) {
            return true;
        } else {
            $this->erroStrongSenha = "Digite uma senha mais forte!";
        }
        # Score retorna um valor de 0 a 4, sendo 0 fraca e 4 muito forte
    }

    # Verifica se o captcha esta correto
    public function validateCaptcha($captcha, $score=0.5)
    {   
        $retorno = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRETKEY."&response={$captcha}");
        $response = json_decode($retorno);
        if($response->success == true && $response->score >= $score) {
            return true;
        } else {
            $this->setErro("Captcha Inválido! Atualize a página e tente novamente.");
            return false;
        }
    }

    public function validateFinalCad()
    {
        $arrResponse = array();
        
        if(count($this->getErro()) > 0 ) {
            $arrResponse["retorno"] = "erro";
            $arrResponse["erros"] = $this->getErro();
        }

        if($this->erroCPF != NULL)
        {
            $arrResponse["retorno"] = "erro";
            $arrResponse["cpf"] = $this->erroCPF;   
        }

        if ($this->erroEmail != NULL){
            $arrResponse["retorno"] = "erro";
            $arrResponse["email"] = $this->erroEmail;
        } 

        if($this->erroStrongSenha != NULL) {
            $arrResponse["retorno"] = "erro";
            $arrResponse["senhaStrong"] = $this->erroStrongSenha;
        } 
        if($this->erroConfSenha != NULL){
            $arrResponse["retorno"] = "erro";
            $arrResponse["senhaConf"] = $this->erroConfSenha;
        }

        if(count($arrResponse) == 0){
            $arrResponse["retorno"] = "success";
        }
        
        return json_encode($arrResponse);
    }
}