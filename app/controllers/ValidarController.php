<?php
# Namespace
namespace App\Controllers;

# Use
use App\Models\CadastrarDB;
use ZxcvbnPhp\Zxcvbn;
use App\Models\LoginDB;
use App\Controllers\LoginController;
use Src\Core\Mail;
use Exception;
use Src\Core\TrataErro;

# Classe Cadastrar
class ValidarController
{   
    private $erro = [];
    private $cadastroDB;
    private $mail;
    private $loginDB;
    # Erros
    private $dadosNull = NULL;
    private $captchaErro = NULL;
    private $erroEmail = NULL;
    private $erroCPF = NULL;
    private $erroStrongSenha = NULL;
    private $erroConfSenha = NULL;
    
    public function __construct()
    {
        # Instancia da Class CadastrarDB
        $this->cadastroDB = new CadastrarDB;
        $this->loginDB = new LoginDB();
        $this->mail = new Mail();
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
        
        if($i == 0) {
            return true;
        } else {
            $this->setErro('Preencha todos os dados!');
            return false;
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
                return $email;
            }
        }
    }

    #Valida se email existe no banco de dados
    public function validaIssetEmail($email)
    {   
        if($email == NULL) {
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
                $this->setErro("Digite 11 números do CPF!");
                return false;
            }
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                $this->setErro("CPF não aceita números sequências!");
                return false;
            }
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $this->setErro("CPF Inválido!");
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
            $this->setErro("A Confirmação de senha está diferente da senha");
            return false;
        }
    }

    # Verifica a força da senha
    public function validateStrongSenha($senha, $par=null)
    {   
        // Referencia https://github.com/bjeavons/zxcvbn-php
        $zxcvbn = new Zxcvbn();
        if($senha != NULL) {
            $strength = $zxcvbn->passwordStrength($senha);
            if($strength['score'] >= 3) {
                return true;
            } else {
                $this->setErro("Digite uma senha mais forte!");
            }
        } else {
            $this->setErro("Informe sua senha!");
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

    # Valida dados Unique do banco de dados
    public function validaDadosUniq($arraVar)
    {   
        # Retorno do formulario
        $retorno = [
            "cpf" => $arraVar['cpf'],
            "rg" => $arraVar['rg'],
            "email" => $arraVar['email'],
            "login" => $arraVar['login']
        ];
        
        # Retorno do banco de dados
        $consulta = $this->cadastroDB->getDadosUniq($retorno);
        
        # Condições
        if($retorno['cpf'] === $consulta['cpf']) {
            $this->setErro('CPF já cadastrado em nosso sistema!');
        }
        if($retorno['rg'] === $consulta['rg']){
            $this->setErro('Rg já cadastrado em nosso sistema!');
        }
        if($retorno['email'] === $consulta['email']) {
            $this->setErro('Email já cadastrado em nosso sistema!');
        }
        if($retorno['login'] === $consulta['login']) {
            $this->setErro('Login já cadastrado em nosso sistema!');
        }
        if(count($this->getErro()) > 0) {
            return false;
        }
        return true;
    }

    public function validateFinalCad($arraVar)
    {   
        $assunto = "<h1>Poupemais</h1>";
        $assunto .= "<h2>Confirmação de Cadastro</h2>";
        $assunto .= "Sr(a) <strong>" . $arraVar["nome"] . "</strong>,";
        $assunto .= "<p>A equipe Poupemais agradece por acreditar em nosso trabalho!</p>";
        $assunto .= "<p>Favor confirmar cadastro em até 5 dias após o cadastro.</p><br>";
        $assunto .= "<p>Abaixo segue o link para a confirmação!</p>";
        $assunto .= "Confirme seu email <a href=". DIRPAGE ."/login/confirmation/{$arraVar['email']}/{$arraVar['token']}>clicando aqui<a/>";
        $assunto .= "<br><br><br>";
        $assunto .= "Att,<br> Poupemais<br>Tel. 11-2222-2222<br>E-mail: contato@poupemais.com";
        
        $arrResponse = array();
        if(count($this->getErro()) > 0) {
            $arrResponse["retornoCad"] = "erro";
            $arrResponse["erros"] = $this->getErro();
        } else {
            # Insere o usuario
            $this->cadastroDB->insertUser($arraVar);
            # Insere o cliente
            $this->cadastroDB->insertCliente($arraVar);
            # Insere o investimento
            $this->cadastroDB->insertInvest($arraVar);
            # Insere a confirmação de email
            $this->cadastroDB->insertConfirmation($arraVar);
            # Seleciona as parcelas do vencimentos
            $vencimentos;
            if($arraVar['plano'] <= 4) {
                $vencimentos = $this->calcularParcelas(6);
            } else {
                $vencimentos = $this->calcularParcelas(12);
            }
            $this->cadastroDB->insertVencimentos($vencimentos,$arraVar);
            $arrResponse = [
                "email" => $this->mail->sendMail(
                $arraVar['email'],
                $arraVar['login'], 
                $arraVar['token'],
                'Confirmação de Cadastro', 
                $assunto),
                    "retornoCad" => [
                        "retorno" => "success",
                        "erros" => $arraVar['token']
                    ]
            ];
        }
        return json_encode($arrResponse);        
    }

    # Método de validação de confirmação de email
    # Verifica o status e se a data de cadastro e menor ou igual a 5 dias depois
    public function validateUserActive(LoginDB $classLogin, $login, LoginController $controller)
    {
        $user = $classLogin->getUser($login);
    
        # Confirma se o status está igual a confirmar
        if($user['data']['status'] == "confirmar") {
            # Caso esteja ele verifica se o prazo esta dentro do 5 dias a conta da data cadastro
            if(strtotime($user['data']['data_cadastro']) <=  strtotime(date("Y-m-d H:i:s")) - 432000) {
                # Caso não retorna um erro
                $controller->setErro("Ative seu cadastro pelo link do email");
                return false;
            }
        } else {
            return true;
        }
    }

    # Calcula as datas da parcelas
    private function calcularParcelas($nParcelas, $dataPrimeiraParcela = null)
    {   
        $dataVencimento = [];
        if($dataPrimeiraParcela != null){
            $dataPrimeiraParcela = explode( "/",$dataPrimeiraParcela);
            $dia = $dataPrimeiraParcela[0];
            $mes = $dataPrimeiraParcela[1];
            $ano = $dataPrimeiraParcela[2];
        } else {
            $dia = date("d");
            $mes = date("m");
            $ano = date("Y");
        }

        for($x = 0; $x < $nParcelas; $x++){
            $dado = date("Y/m/d",strtotime("+".$x." month",mktime(0, 0, 0,$mes,$dia,$ano)));
            array_push($dataVencimento, $dado); 
        }
        return $dataVencimento;
    }

    # Validação de confirmação de cadastro
    public function validateConfirmation(loginController $loginController, $email,$token)
    {   
        $arrData = [
            "email" => $email,
            "token" => $token
        ];
        try {
            $status = $this->loginDB->statusConfirmation($arrData['email']);
            if($status > 0) {
                $row = $this->loginDB->selectConfirmation($arrData);                
                if($row > 0){
                    $this->loginDB->deleteConfirmation($arrData);
                    $this->loginDB->updateConfirmation($arrData['email']);
                    return $status;
                } else {
                    $loginController->setErro('Cadastro não confirmado, entre em contato com a Poupemais.');
                    return false;
                }
            } else {
                $loginController->setErro('Cadastro já confirmado!');
                return false;
            }
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
        
    }
}