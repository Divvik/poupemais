<?php
# Namespace
namespace App\Controllers;

# Use
use App\Models\CadastrarDB;
use Src\Core\ClassCrud;
use App\Controllers\PasswordController;
use PDO;
use ZxcvbnPhp\Zxcvbn;


# Classe Cadastrar
class ValidarController
{   
    private $erro = [];
    private $cadastro;
    private $nome;
    private $cpf;
    private $rg;
    private $estado_civil;
    private $endereco;
    private $bairro;
    private $cep;
    private $cidade;
    private $estado;
    private $telefone;
    private $email;
    private $login;
    private $senha;
    private $hashSenha;
    private $confSenha;
    private $dataCreate;
    private $token;
    private $status = 'confirmation';
    private $gRecaptchaResponse;

    public function __construct()
    {   
        # Instancia da Class CadastrarDB
        $this->cadastro = new CadastrarDB();

        # Validações 
        $this->validarCadastro($_POST);
        $this->validarFields();
        $this->validaConfSenha($this->senha, $this->confSenha);
        $this->validaEmail('c_email');
        $this->validaIssetEmail($this->email);
        $this->validaCpf('c_cpf');
        $this->validateStrongSenha($this->senha);
        $this->validateCaptcha($this->gRecaptchaResponse);

        # Array com as informações do cadastro
        $arraVar = [
            "email"=>$this->email,
            "hashSenha"=>$this->hashSenha,
            "login"=>$this->login,
            "nome"=>$this->nome,
            "cpf"=>$this->cpf,
            "rg"=>$this->rg,
            "estado_civil"=>$this->estado_civil,
            "endereco"=>$this->endereco,
            "bairro"=>$this->bairro,
            "cep"=>$this->cep,
            "cidade"=>$this->cidade,
            "estado"=>$this->estado,
            "telefone"=>$this->telefone,
            "date_cadastro"=>$this->dataCreate,
            "status"=>$this->status,
            "token"=>$this->token,
        ];

        # Validação final do formulario junto com json
        echo $this->validateFinalCad($arraVar); 
        # Dados enviado para o banco de dados
        // $this->cadastro->insertUser($arraVar);
        // $this->cadastro->insertCliente($arraVar,$this->cadastro->selectUltId());
        // $this->cadastro->insertConfirmation($arraVar);
        
    }
    
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
        
        if($i==0) {
            return true;
            
        } else {
            $this->setErro('Preencha todos os dados!');
            return false;
        }
    }

    # Valida os campos vindo do formulario
    public function validarFields()
    {   
        # Validando os campos 
        (isset($_POST['c_nome']) && !empty($_POST['c_nome']) ? $this->nome = filter_input_post('c_nome') : $this->nome = null); 
        (isset($_POST['c_cpf']) && !empty($_POST['c_cpf']) ? $this->cpf = filter_input_post('c_cpf') : $this->cpf = null);
        (isset($_POST['c_rg']) && !empty($_POST['c_rg']) ? $this->rg = filter_input_post('c_rg') : $this->rg = null);
        (isset($_POST['c_estado_civil']) && !empty($_POST['c_estado_civil']) ? $this->estado_civil = filter_input_post('c_estado_civil') : $this->estado_civil = null);
        (isset($_POST['c_endereco']) && !empty($_POST['c_endereco']) ? $this->endereco = filter_input_post('c_endereco') : $this->endereco = null);
        (isset($_POST['c_bairro']) && !empty($_POST['c_bairro']) ? $this->bairro = filter_input_post('c_bairro') : $this->bairro = null);
        (isset($_POST['c_cep']) && !empty($_POST['c_cep']) ? $this->cep = filter_input_post('c_cep') : $this->cep = null);
        (isset($_POST['c_cidade']) && !empty($_POST['c_cidade']) ? $this->cidade = filter_input_post('c_cidade') : $this->cidade = null);
        (isset($_POST['c_estado']) && !empty($_POST['c_estado']) ? $this->estado = filter_input_post('c_estado') : $this->estado = null);
        (isset($_POST['c_telefone']) && !empty($_POST['c_telefone']) ? $this->telefone = filter_input_post('c_telefone') : $this->telefone = null);
        (isset($_POST['c_email']) && !empty($_POST['c_email']) ? $this->email = filter_input(INPUT_POST, 'e_email', FILTER_VALIDATE_EMAIL) : $this->email = null);
        (isset($_POST['c_login']) && !empty($_POST['c_login']) ? $this->login = filter_input_post('c_login') : $this->login = null);
        (isset($_POST['c_g-recaptcha-response']) && !empty($_POST['c_g-recaptcha-response'])) ? $this->gRecaptchaResponse = $_POST['c_g-recaptcha-response'] : $this->gRecaptchaResponse = NULL;
        # Criando uma senha hash 
        $objPass = new PasswordController();
        if(isset($_POST['c_senha']) && !empty($_POST['c_senha'])) { 
            $this->senha = filter_input_post('c_senha'); 
            $this->hashSenha = $objPass->passwordHash($this->senha);
        } else{
            $this->hashSenha = null; 
        }

        if(isset($_POST['c_conf-senha']) && !empty($_POST['c_conf-senha'])) {
            $this->confSenha = filter_input_post('c_conf-senha');
        } else{
            $this->confSenha = null; 
        }

        # Se estiver passando dados via post cria uma data atual e um token
        if(isset($_POST)) {
            $this->dataCreate = date("Y-m-d H:i:s");
            $this->token=bin2hex(random_bytes(64));
        } else {
            $this->dataCreate = NULL;
            $this->token = NULL;
        }
    }
    
    # Validação de email
    public function validaEmail($c_email)
    {
        if(isset($_POST[$c_email]) && !empty($_POST[$c_email])){

            $email = filter_input(INPUT_POST, $c_email, FILTER_VALIDATE_EMAIL);
            
            if(!$email) {
                $this->email = NULL;
                $this->setErro("Email inválido!");
                return false;
            } else {
                return $this->email = $email;
            }
        }
    }

    #Valida se email existe no banco de dados
    public function validaIssetEmail($email)
    {
        $b = $this->cadastro->getEmail($email);

        if($b > 0) {
            $this->setErro("Email ja cadastrado!");
            return false;
        } else {
            return true;
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
                $this->setErro("Digite 11 numeros do CPF!");
                return false;
            }
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                $this->setErro("CPF nao aceita numeros sequencias!");
                return false;
            }
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $this->setErro("CPF Invalido!");
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
            $this->setErro("A Confirmacao de senha esta diferente da senha");
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
            $this->setErro("Digite uma senha mais forte!");
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
            $this->setErro("Captcha Invalido! Atualize a pagina e tente novamente.");
            return false;
        }
    }

    public function validateFinalCad($arraVar)
    {
        if(count($this->getErro()) > 0 ) {
            $arrResponse = [
                "retorno" => "erro",
                "erros" => $this->getErro()
            ];
        } else {
            echo "teste";
        }
        return json_encode($arrResponse);
    }
}