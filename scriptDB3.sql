-- MySQL Script generated by MySQL Workbench
-- Thu Apr  4 00:39:12 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_poupemais
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_poupemais
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_poupemais` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci ;
USE `db_poupemais` ;

-- -----------------------------------------------------
-- Table `db_poupemais`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(25) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `data_cadastro` DATE NOT NULL,
  `status` VARCHAR(10) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`clientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `cpf` VARCHAR(15) NOT NULL,
  `rg` VARCHAR(15) NOT NULL,
  `estado_civil` VARCHAR(10) NOT NULL,
  `telefone` VARCHAR(15) NOT NULL,
  `endereco` VARCHAR(50) NOT NULL,
  `bairro` VARCHAR(30) NOT NULL,
  `cep` VARCHAR(9) NOT NULL,
  `cidade` VARCHAR(25) NOT NULL,
  `estado` CHAR(2) NOT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id`, `id_usuario`),
  UNIQUE INDEX `rg_UNIQUE` (`rg` ASC),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC),
  INDEX `fk_cliente_usuario_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_cliente_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_poupemais`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`planos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`planos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`grupos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`investimentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`investimentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numero_investimento` INT NOT NULL,
  `data_contratacao` DATE NOT NULL,
  `id_cliente` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `id_plano` INT NOT NULL,
  `id_grupo` INT NOT NULL,
  PRIMARY KEY (`id`, `id_cliente`, `id_usuario`, `id_plano`, `id_grupo`),
  INDEX `fk_investimento_cliente1_idx` (`id_cliente` ASC, `id_usuario` ASC),
  INDEX `fk_investimento_planos1_idx` (`id_plano` ASC),
  INDEX `fk_investimento_grupos1_idx` (`id_grupo` ASC),
  CONSTRAINT `fk_investimento_cliente1`
    FOREIGN KEY (`id_cliente` , `id_usuario`)
    REFERENCES `db_poupemais`.`clientes` (`id` , `id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_investimento_planos1`
    FOREIGN KEY (`id_plano`)
    REFERENCES `db_poupemais`.`planos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_investimento_grupos1`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `db_poupemais`.`grupos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`vencimentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`vencimentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `parcela` INT NOT NULL,
  `vencimento` DATE NOT NULL,
  `valor` DECIMAL(7,2) NOT NULL,
  `data_pagamento` DATE NULL,
  `situacao` VARCHAR(20) NOT NULL,
  `investimentos_id` INT NOT NULL,
  PRIMARY KEY (`id`, `investimentos_id`),
  INDEX `fk_vencimentos_investimentos1_idx` (`investimentos_id` ASC),
  CONSTRAINT `fk_vencimentos_investimentos1`
    FOREIGN KEY (`investimentos_id`)
    REFERENCES `db_poupemais`.`investimentos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`confirmation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`confirmation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NULL,
  `token` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`tentativas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`tentativas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(20) NULL,
  `date` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

/* FUNÇÕES */
/* NOW () DATA E HORA ATUAL */
/* CURDATE() DATA ATUAL */
/* CURTIME() HORA ATUAL */

/* USE DATA BASE */
USE db_poupemais;

/* SHOW TABLE */
SHOW TABLES;

/* USUARIO */
SELECT * FROM usuarios;
INSERT INTO usuarios (login, senha, email,data_cadastro,status) VALUES ('paulo',md5('123456'),'paulo@paulo.com.br',NOW(),'confirmar');
INSERT INTO usuarios (login, senha, email,data_cadastro,status) VALUES ('maria',md5('123456'),'maria@maria.com.br',NOW(),'confirmar');

/* CLIENTES */
SELECT * FROM clientes;
INSERT INTO clientes (nome,cpf,rg,estado_civil,telefone,endereco,bairro,cep,cidade,estado,id_usuario) 
			  VALUES ('Paulo Afonso Carvalho','111.222.333-44','11.222.333-4','solteiro','11-9.9999-9999','Av tamoio, 1560 apto 55-A','Morro','12345-678','São Paulo','SP',1);
INSERT INTO clientes (nome,cpf,rg,estado_civil,telefone,endereco,bairro,cep,cidade,estado,id_usuario) 
			  VALUES ('Maria Afonso Carvalho','555.666.777-88','55.666.777-8','casada','11-9.9999-9999','Av tamoio, 1560 apto 55-A','Morro','12345-678','São Paulo','SP',2);
/* PLANOS */
SELECT * FROM planos;
INSERT INTO planos (nome) VALUES ('6 MESES 50'),('6 MESES 100'),('6 MESES 150'),('6 MESES 200'),('12 MESES 50'),('12 MESES 100'),('12 MESES 150'),('12 MESES 200');

/* GRUPOS */
SELECT * FROM grupos;
INSERT INTO grupos (nome) VALUES ('Grupo1'),('Grupo2'),('Grupo3');

/* INVESTIMENTO */
SELECT * FROM investimentos;
INSERT INTO investimentos (numero_investimento,data_contratacao,id_cliente,id_usuario,id_grupo) VALUES (0001,CURDATE(),1,1,1);
INSERT INTO investimentos (numero_investimento,data_contratacao,id_cliente,id_usuario,id_grupo) VALUES (0002,CURDATE(),2,5,2);
INSERT INTO investimentos (numero_investimento,data_contratacao,id_cliente,id_usuario,id_grupo) VALUES (0003,CURDATE(),2,2,1);

/* VENCIMENTOS */
SELECT * FROM vencimentos;
INSERT INTO vencimentos (parcela,vencimento,valor,situacao,investimentos_id) VALUES 
																	(1,'2019-04-03','50.00','pago',1),
																	(2,'2019-05-03','50.00','aberto',1),
																	(3,'2019-06-03','50.00','aberto',1),
                                                                    (4,'2019-07-03','50.00','aberto',1),
                                                                    (5,'2019-08-03','50.00','aberto',1),
                                                                    (6,'2019-04-03','50.00','aberto',1);
                                                                    
INSERT INTO vencimentos (parcela,vencimento,valor,situacao,investimentos_id) VALUES (1,'2019-01-03','50.00','pago',2),
																	(2,'2019-02-03','50.00','aberto',2),
																	(3,'2019-03-03','50.00','aberto',2),
                                                                    (4,'2019-04-03','50.00','aberto',2),
                                                                    (5,'2019-05-03','50.00','aberto',2),
                                                                    (6,'2019-06-03','50.00','aberto',2),
                                                                    (7,'2019-07-03','50.00','aberto',2),
																	(8,'2019-08-03','50.00','aberto',2),
																	(9,'2019-09-03','50.00','aberto',2),
                                                                    (10,'2019-10-03','50.00','aberto',2),
                                                                    (11,'2019-11-03','50.00','aberto',2),
                                                                    (12,'2019-12-03','50.00','aberto',2);

INSERT INTO vencimentos (parcela,vencimento,valor,situacao,investimentos_id) VALUES 
																	(1,'2019-04-03','100.00','pago',3),
																	(2,'2019-05-03','100.00','aberto',3),
																	(3,'2019-06-03','100.00','aberto',3),
                                                                    (4,'2019-07-03','100.00','aberto',3),
                                                                    (5,'2019-08-03','100.00','aberto',3),
                                                                    (6,'2019-04-03','100.00','aberto',3);
/* BAIXA DO PAGAMENTO */
UPDATE vencimentos AS v JOIN investimentos AS i ON i.id = v.investimentos_id SET v.data_pagamento = '2019-02-03', v.situacao = 'pago' WHERE v.parcela = 2 AND i.numero_investimento = 2;
UPDATE vencimentos AS v JOIN investimentos AS i ON i.id = v.investimentos_id SET v.situacao = 'pago' WHERE v.parcela = 2 AND i.numero_investimento = 2;
UPDATE vencimentos AS v JOIN investimentos AS i ON i.id = v.investimentos_id SET v.situacao = 'aguardando' WHERE v.parcela = 3 AND i.numero_investimento = 2;  

                                                                    
/* SELECT FROM VENCIMENTO */

/* Seleção de todos investimentos da do cliente*/
SELECT c.nome, i.numero_investimento AS nº_investimento, i.data_contratacao AS contratacao, v.parcela, v.vencimento AS dt_vencimento, v.valor,v.data_pagamento, v.situacao, p.nome AS plano, g.nome AS grupo FROM
		investimentos AS i
        JOIN clientes AS c ON c.id = i.id_cliente
        JOIN planos AS p ON p.id = i.id_plano
        JOIN vencimentos AS v ON v.investimentos_id = i.id 
        JOIN grupos AS g ON g.id = i.id_grupo WHERE c.id = 2 AND i.numero_investimento = 2 ORDER BY v.situacao DESC, v.vencimento ASC;
        
