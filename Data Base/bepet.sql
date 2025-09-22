-- Cria o banco de dados se ele não existir e o seleciona para uso
CREATE DATABASE IF NOT EXISTS bepet;
USE bepet;

-- Remove a tabela 'mensagem' se ela já existir, para evitar erros
DROP TABLE IF EXISTS mensagem;

-- Cria a tabela 'mensagem' para armazenar contatos do site
CREATE TABLE mensagem (
    codigo BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL
);

-- Insere um dado de exemplo na tabela 'mensagem'
INSERT INTO mensagem (nome, email, mensagem) VALUES ('Carlos', 'carlos@gmail.com', 'Adorei o site!');

-- Remove a tabela 'login' se ela já existir, para evitar erros
DROP TABLE IF EXISTS login;

-- Cria a tabela 'login' para armazenar dados de usuários
CREATE TABLE login (
    codigo BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, -- Adicionar UNIQUE é uma boa prática para e-mails
    senha VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('user', 'admin') NOT NULL DEFAULT 'user' -- Coluna adicionada aqui
);