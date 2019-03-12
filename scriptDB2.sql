use poupemais;
show tables;
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

create table venda (
	id int primary key not null auto_increment,
    cod_venda int not null,
    valor decimal(7,2) not null,
    data_contrato date not null
);

create table parcelas (
	id int primary key not null auto_increment,
    parcela int not null,
    valor_parcela decimal(7,2) not null,
    vencimento date not null
);

create table planos (
	id int primary key not null auto_increment,
    plano decimal(7,2) not null
);

create table plano_prazo (
	id int primary key not null auto_increment,
    prazo int not null
);


/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/* SQL - Inserindo dados na tabela */
insert into contas_receber (valor,a_vencer,vencido,id_situacao) value (20.00,'2019-02-27','2019-01-27',1);
insert into contas_receber (valor,a_vencer,vencido,id_situacao) value (30.00,'2019-02-28','2019-02-27',2);
insert into situacao_ctas_receber (nome) value ('pago'),('atrasado'),('aguardando'),('aberto');

insert into cliente (nome, endereco, cidade, estado) values ('Fernando A. Estevam','Rua bartolomeu ferrari,544 apto 11-A', 'São Paulo','SP');

insert into grupos (nome) values ('EUA'),('Canada'),('Mexico'),('Colombia');

insert into planos (nome) values ('6 meses'),('12 meses');

insert into situacao_usuario (nome) value ('Ativo'),('Bloqueado'),('Suspenso');

insert into usuarios (login, password) values ('fubatdz',md5('123456'));

insert into planos (plano) values (50.00),(100.00),(150.00),(200.00);

insert into plano_prazos (prazo) value (6),(12);
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/* SQL - Seleção da tabela */
select * from vendas;

select c.id, c.nome, cr.valor,cr.a_vencer,cr.vencido, sr.nome as situcao from situacao_ctas_receber as sr join contas_receber as cr on cr.id = sr.id join clientes as c on cr.id = c.id;
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/* SLQ - Alterar dados da tabela */
alter table clientes add column sobrenome varchar(100) not null;

alter table venda rename to vendas;

alter table clientes change nome_completo nome varchar(50) not null;

alter table venda add column id_grupos int not null;

alter table contas_receber add constraint fk_id_cliente foreign key (id_cliente) references clientes (id);

alter table clientes modify column cidade varchar(100) not null after endereco;
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/* SQL - Atualizando dados da coluna da tabela */
update clientes set sobrenome = 'Antonio Estevam' where id = 1;
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/* SLQ - Descrição das tabelas */
desc plano_prazos;  
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/* SLQ - Delete table */
drop table planos;