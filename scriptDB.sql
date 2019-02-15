/* Criando data base */
CREATE DATABASE db_poupemais;

/* Usando o banco de dados */
use db_poupemais;
 
 /* Criando tabelas */
 CREATE TABLE usuario (
	idUsuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    email VARCHAR(50),
    senha VARCHAR(255)
);

INSERT INTO usuario (nome,email,senha) VALUES ('fernando','fernandoestevam23@gmail.com',md5('123456'));

SELECT * FROM usuario;

DELETE FROM usuario WHERE idUsuario = '2';

