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

 -- Migration to create the 'produtos' table
 
 CREATE TABLE IF NOT EXISTS produtos (
     id INT AUTO_INCREMENT PRIMARY KEY,
     nome VARCHAR(100) NOT NULL,
     descricao TEXT,
     preco DECIMAL(10, 2) NOT NULL,
     caminho_imagem VARCHAR(255) NOT NULL,
     data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 );

-- Insere dados de exemplo na tabela 'mensagem'
INSERT INTO mensagem (nome, email, mensagem) VALUES
('Ana Silva', 'ana.silva@example.com', 'Gostaria de saber mais sobre os serviços de banho e tosa.'),
('Bruno Costa', 'bruno.c@example.com', 'Vocês têm serviço de leva e traz para animais?'),
('Juliana Pereira', 'juju.pereira@email.com', 'Meu cachorro é muito ansioso, vocês têm experiência com animais assim?'),
('Marcos Oliveira', 'marcos.oli@server.com', 'Excelente atendimento! Recomendo a todos.'),
('Fernanda Souza', 'fernanda.souza@mail.com', 'Qual o horário de funcionamento aos sábados?'),
('Carlos', 'carlos@gmail.com', 'Adorei o site!'); -- Seu insert original, agora no final.