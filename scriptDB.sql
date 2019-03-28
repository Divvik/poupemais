-- MySQL Script generated by MySQL Workbench
-- Wed Mar 13 00:24:59 2019
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
CREATE SCHEMA IF NOT EXISTS `db_poupemais` DEFAULT CHARACTER SET utf8 ;
USE `db_poupemais` ;

-- -----------------------------------------------------
-- Table `db_poupemais`.`tb_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`tb_usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `senha` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `login` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`tb_cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`tb_cliente` (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `nomeCliente` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `cpf` VARCHAR(14) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `rg` VARCHAR(13) NOT NULL,
  `estado_civil` VARCHAR(10) NULL,
  `endereco` VARCHAR(180) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `bairro` VARCHAR(50) NOT NULL,
  `cep` VARCHAR(9) NOT NULL,
  `cidade` VARCHAR(80) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `estado` CHAR(2) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `telefone` VARCHAR(18) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `date_cadastro` DATETIME NOT NULL,
  `status` VARCHAR(30) NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idCliente`, `idUsuario`),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC),
  INDEX `fk_tb_cliente_tb_usuario_idx` (`idUsuario` ASC),
  UNIQUE INDEX `rg_UNIQUE` (`rg` ASC),
  CONSTRAINT `fk_tb_cliente_tb_usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `db_poupemais`.`tb_usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`tb_planos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`tb_planos` (
  `idPlano` INT NOT NULL AUTO_INCREMENT,
  `nomePlano` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `valorPlano` DECIMAL(7,2) NOT NULL,
  PRIMARY KEY (`idPlano`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`tb_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`tb_grupos` (
  `idGrupo` INT NOT NULL AUTO_INCREMENT,
  `nomeGrupo` VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  PRIMARY KEY (`idGrupo`),
  UNIQUE INDEX `idGrupo_UNIQUE` (`idGrupo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`tb_usuario_invest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`tb_usuario_invest` (
  `idInvest` INT NOT NULL AUTO_INCREMENT,
  `vencimento` DATE NOT NULL,
  `idCliente` INT NOT NULL,
  `idPlano` INT NOT NULL,
  `situacao` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `idGrupo` INT NOT NULL,
  PRIMARY KEY (`idInvest`, `idCliente`, `idPlano`, `idGrupo`),
  INDEX `fk_tb_usuario_invest_tb_cliente1_idx` (`idCliente` ASC),
  INDEX `fk_tb_usuario_invest_tb_planos1_idx` (`idPlano` ASC),
  INDEX `fk_tb_usuario_invest_tb_grupos1_idx` (`idGrupo` ASC),
  CONSTRAINT `fk_tb_usuario_invest_tb_cliente1`
    FOREIGN KEY (`idCliente`)
    REFERENCES `db_poupemais`.`tb_cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_usuario_invest_tb_planos1`
    FOREIGN KEY (`idPlano`)
    REFERENCES `db_poupemais`.`tb_planos` (`idPlano`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_usuario_invest_tb_grupos1`
    FOREIGN KEY (`idGrupo`)
    REFERENCES `db_poupemais`.`tb_grupos` (`idGrupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`tb_pagamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`tb_pagamentos` (
  `idPagamento` INT NOT NULL AUTO_INCREMENT,
  `idInvest` INT NOT NULL,
  `idCliente` INT NOT NULL,
  `dataPag` DATE NULL,
  PRIMARY KEY (`idPagamento`, `idInvest`, `idCliente`),
  INDEX `fk_tb_pagamentos_tb_usuario_invest1_idx` (`idInvest` ASC, `idCliente` ASC),
  CONSTRAINT `fk_tb_pagamentos_tb_usuario_invest1`
    FOREIGN KEY (`idInvest` , `idCliente`)
    REFERENCES `db_poupemais`.`tb_usuario_invest` (`idInvest` , `idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_poupemais`.`attempt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`attempt` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(20) NULL,
  `date` DATETIME NULL,
  PRIMARY KEY (`id`))
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

USE `db_poupemais` ;

-- -----------------------------------------------------
-- Placeholder table for view `db_poupemais`.`view1`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_poupemais`.`view1` (`id` INT);

-- -----------------------------------------------------
-- View `db_poupemais`.`view1`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_poupemais`.`view1`;
USE `db_poupemais`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



/* Use banco de dados */
USE db_poupemais;

/* Mostra as tabelas */
SHOW TABLES;

/* Descrição tabela */
DESC tb_cliente;
DESC tb_usuario;
DESC tb_usuario_invest;
DESC tb_planos;
DESC tb_pagamentos;
DESC tb_grupos;

/* Inserção de dados */

/* Inserção tabela usuarios */
INSERT INTO tb_usuario (email,senha,login) VALUES 
	('admin@admin.com',md5('123'),'admin');
    
INSERT INTO tb_usuario (email,senha,login) VALUES 
	('joãodasilva@gmail.com',md5('123456'),'joao_silva'),
    ('pauloafonso@gmail.com',md5('123456'),'paulo_afonso');


/* Inserção tabela cliente */
INSERT INTO tb_cliente (nomeCliente,cpf,endereco,bairro,cep,cidade,estado,telefone,idUsuario) VALUES
					('Elton','111.111.111-11','Rua vida nova, 34' ,'Vida velha','12345-000','São Paulo','SP','11-99999-9999',1),
					('João da Silva','111.222.333-12','Rua da vida, 30','Vida nova','12345-000','São Paulo','SP','11-9999-9999',2),
				   ('Paulo Afonso','444.555.666-45','Rua proxima, 30','Vida nasce','12345-000', 'Rio de janeiro','RJ','1198888-8888',3);
                 
DELETE FROM confirmation WHERE id = 3;
SELECT * FROM tb_usuario WHERE email = 'paulo@paulo.com.br';

/* Seleção tabela */
SELECT * FROM tb_cliente;
SELECT * FROM tb_usuario;
SELECT * FROM confirmation;

ALTER TABLE `tb_usuario` CHANGE `senha` `senha` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

SELECT * FROM tb_usuario WHERE email = 'carlosmaduraira@gmail.com';


INSERT INTO tb_usuario (email,senha,login) VALUES('paulo@paulo.com.br',md5('709244'),'paulo');

INSERT INTO tb_usuario VALUES ("teste@teste","709244","teste");

INSERT INTO tb_cliente (nomeCliente,cpf,rg,estado_civil,endereco,bairro,cep,cidade,estado,telefone,date_cadastro,status,idUsuario) 
            VALUES('Paulo Afonso','323.322.808-20','40.633.778-0','solteiro','Rua paraiba, nº 132 Apto 22-D','Vila Nova','01235-610','São Paulo','SP','(11)9.9999-9999','2019-03-12 22:37:20','confirmation','1');

/* Seleção tabela */
SELECT * FROM tb_usuario ORDER BY idUsuario DESC limit 1; 
SELECT * FROM tb_usuario WHERE login = 'admin' AND senha = md5('123');


SELECT * FROM tb_usuario WHERE login = 'joao_silva' AND senha = MD5('123456');

INSERT INTO tb_planos (nomePlano,valorPlano) VALUES 
	('6 meses 50',50.00), ('6 meses 100',100.00),
    ('6 meses 150',150.00), ('6 meses 200',200.00),
    ('12 meses 50',50.00), ('12 meses 100',100.00),
    ('12 meses 150',150.00), ('12 meses 200',200.00);

SELECT * FROM tb_grupos;

INSERT INTO tb_grupos (nomeGrupo) VALUES ('Brasil'),('EUA'),('Canada');

/* Seleceção tabela */
SELECT * FROM tb_grupos;

DELETE FROM tb_grupos WHERE idGrupo = 9;

DELETE FROM confirmation WHERE id = 3;

INSERT INTO tb_usuario_invest (vencimento,idCliente,idPlano,situacao,idGrupo) VALUES 
	('2019-06-23',1,1,'aberto',1),('2019-07-23',1,1,'aberto',1),
    ('2019-08-23',1,1,'aberto',1),('2019-09-23',1,1,'aberto',1),
    ('2019-10-23',1,1,'aberto',1),('2019-11-23',1,1,'aberto',1),
    ('2019-06-23',2,2,'aberto',2),('2019-07-23',2,2,'aberto',2),
    ('2019-08-23',2,2,'aberto',2),('2019-09-23',2,2,'aberto',2),
    ('2019-10-23',2,2,'aberto',2),('2019-11-23',2,2,'aberto',2);
    
/* Seleção tabela */
SELECT count(*) FROM tb_usuario_invest;

/* ALGO DE ERRADO NESSA TABELA */
/*INSERT INTO tb_pagamentos (idInvest,idCliente,dataPag) VALUES (2,1,'2019-07-30');*/

/* Seleção tabela */
SELECT * FROM tb_pagamentos;

/* Seleção usando o join tabela cliente e usuario */
SELECT c.idCliente,c.nomeCliente, c.cpf, u.login, u.email FROM tb_cliente AS c JOIN tb_usuario AS u ON u.idUsuario = c.idCliente;

/* Seleção usando o join tabela pagamentos */
SELECT c.nomecliente, pla.nomePlano, pag.dataPag FROM tb_pagamentos AS pag 
	JOIN tb_cliente AS c ON c.idCliente = pag.idPagamento 
    JOIN tb_planos AS pla ON pla.idPlano = pag.idPagamento;

/* Seleção usando o join tabela usuario invest */
SELECT * FROM tb_usuario_invest ORDER BY vencimento desc;

SELECT * FROM tb_usuario_invest;

SELECT c.nomeCliente, c.cpf, i.vencimento, i.situacao, pla.nomePlano, pla.valorPlano FROM tb_cliente AS c 
	JOIN tb_usuario_invest AS i ON c.idCliente = i.idCliente 
    JOIN tb_planos AS pla ON pla.idPlano = i.idPlano 
    WHERE c.idCliente = 2 ORDER BY i.vencimento ASC; 


SELECT c.nomeCliente, c.cpf, i.vencimento, i.situacao, pla.nomePlano, pla.valorPlano  
            FROM tb_cliente AS c 
            JOIN tb_usuario_invest AS i ON c.idCliente = i.idCliente 
            JOIN tb_planos AS pla ON pla.idPlano = i.idPlano 
            WHERE c.idCliente = 4  ORDER BY i.vencimento ASC;