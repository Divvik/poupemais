<?php 

# namespace
namespace App\Models;

# use
use PDO;
use Src\Core\ClassCrud;
use Exception;
use Src\Core\TrataErro;

class CadastrarDB extends ClassCrud
{
    private $dataCad;
    private $dataAtual;

    # Data Cadastro 
    public function getDateCad()
    {
        return $this->dataCad = Date('Y-m-d-H:m:i');
    }
    # Data Atual
    public function getDataAtual()
    {
        return $this->dataAtual = Date('Y-m-d');
    }
    
    # Select plano
    public function selectPlano()
    {   
        try {
            $plano = $this->selectDB("*","planos","",array());
            $result = $plano->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
        
    }
    
    # 1° Inserção banco de dados
    # Insere um usuario 
    public function insertUser($arrVar)
    {   
        try {
            $this->insertDB("usuarios (login, senha, email,data_cadastro, status)",
                "?,?,?,?,?",
                array(
                    $arrVar['login'],
                    $arrVar['hashSenha'],
                    $arrVar['email'], 
                    $arrVar['date_cadastro'], 
                    'confirmar'
                )
            );
        }  catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
        
    }
    
    # 2º Inserção banco de dados
    # Insere um cliente
    public function insertCliente($arrVar)
    {   
        
        try {
            $this->insertDB("clientes (nome,cpf,rg,estado_civil,telefone,endereco,bairro,cep,cidade,estado,id_usuario)", 
            "?,?,?,?,?,?,?,?,?,?,?",
                array(
                    $arrVar['nome'],
                    $arrVar['cpf'],
                    $arrVar['rg'],
                    $arrVar['estado_civil'],
                    $arrVar['telefone'],
                    $arrVar['endereco'],
                    $arrVar['bairro'],
                    $arrVar['cep'],
                    $arrVar['cidade'],
                    $arrVar['estado'],
                    $this->selecionaId('usuarios')
                )
            );
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
    }

    # 3º Inserção banco de dados
    # Insere investimentos
    public function insertInvest($plano)
    {   
        try {                    
            $this->insertDB("investimentos (numero_investimento,data_contratacao,id_cliente,id_plano,id_grupo)", 
                "?,?,?,?,?", 
                array(
                    $this->selecionaId('investimentos') + 1,
                    $this->getDateCad(),
                    $this->selecionaId('clientes'),
                    $this->selecionaId('planos'),
                    $this->selecionaId('grupos')
                )
            );
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
    }

    # 4º Inserção banco de dados
    # Insere vencimentos
    public function insertVencimentos($datas,$planos)
    {   
        # Retorna do formulario o plano
        $plano = $planos['plano'];
        
        # Retorna o valor conforme a escolha do plano
        $valor = 0;

        if($plano == 1 || $plano == 5) {
            $valor = 50.00;
        } elseif($plano == 2 || $plano == 6) {
            $valor = 100.00;
        } elseif($plano == 3 || $plano == 7) {
            $valor = 150.00;
        } elseif($plano == 4 || $plano == 8) {
            $valor = 200.00;
        } else {
            return false;
        }
        
        # Seleciona as parcelas conforme o plano escolhido
        $parcela = 0;
        try {
            foreach ($datas as $vencimento) {
                $parcela++;
                $this->insertDB("vencimentos (parcela,vencimento,valor,situacao,investimentos_id)",
                    "?,?,?,?,?",
                    array(
                        $parcela,
                        $vencimento, 
                        $valor,
                        "aberto",
                        $this->selecionaId('investimentos'),
                    )
                );
            }
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
    }
    
    # Insere dados na tabela confirmation (serve para confirma cadastro)
    public function insertConfirmation($arrVar)
    {
        try {
            $this->insertDB("confirmation (email,token)",
                "?,?", 
                array(
                    $arrVar['email'], 
                    $arrVar['token']
                )
            ); 
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
        
    }

    # Seleciona o ultimo id do cliente
    private function selecionaId($table)
    {
        try {
            $query = $this->selectDB("*",$table, "ORDER BY id DESC limit 1", array());
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $id = $result['id'];
            return $id;
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
        
    }

    # Verifica se o email esta cadastrado
    public function getEmail($email)
    {   
        try {
            $query = $this->selectDB("email", "usuarios", "WHERE email = ?", array($email));
            $result = $query->rowCount();
            return $result;
        }  catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
    }

    # Verifica se o CPF já esta cadastrado
    public function getDadosUniq($retorno)
    {
        try {
            $query = $this->selectDB(
                "c.cpf, c.rg, u.login, u.email",
                "clientes AS c JOIN usuarios AS u ON c.id_usuario = c.id",
                "WHERE cpf = ? OR rg = ? OR email = ? OR login = ?", 
                array(
                    $retorno['cpf'],
                    $retorno['rg'],
                    $retorno['email'],
                    $retorno['login'],
                    )
                );
                $row = $query->rowCount();
                $consulta = $query->fetch(PDO::FETCH_ASSOC);
                return $consulta;
        } catch (Exception $e) {
            TrataErro::setErroExeption($e);
        }
    }
    
}