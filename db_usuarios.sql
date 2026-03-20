CREATE DATABASE IF NOT EXISTS db_usuarios;
USE db_usuarios;

CREATE TABLE IF NOT EXISTS tbl_usuario (
    usuario_cpf varchar(11) PRIMARY KEY,
    usuario_nome varchar(20) NOT NULL,
    usuario_senhahash varchar(255) NOT NULL,
    usuario_sexo varchar(1) NOT NULL,
    usuario_datanasc date NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);