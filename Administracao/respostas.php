<?php

// Forçar a exibição de erros durante o desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "bepet";

// 1. CRIAR A CONEXÃO COM O BANCO DE DADOS
// Usaremos o MySQLi para isso. A variável da conexão será $conexao.
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// 2. CHECAR A CONEXÃO
// Se houver um erro, o script para e exibe a mensagem de erro.
if ($conexao->connect_error) {
    // Em um ambiente de produção, seria melhor logar o erro em vez de exibi-lo.
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// 3. CRIAR A QUERY SQL (CONSULTA)
// Selecionamos todas as colunas da tabela "mensagem" e ordenamos pela coluna "codigo" de forma descendente.
$sql = "SELECT codigo, nome, email, mensagem FROM mensagem ORDER BY codigo DESC";

// 4. PREPARAR E EXECUTAR A CONSULTA DE FORMA SEGURA
$stmt = $conexao->prepare($sql);
if ($stmt === false) {
    die("Erro ao preparar a declaração: " . $conexao->error);
}

$stmt->execute();
$resultado = $stmt->get_result();

// 5. TRANSFORMAR O RESULTADO EM UM ARRAY ASSOCIATIVO
$mensagens = [];
if ($resultado) {
    $mensagens = $resultado->fetch_all(MYSQLI_ASSOC);
}

// 6. FECHAR A CONEXÃO COM O BANCO
$stmt->close();
$conexao->close();

// 7. CHAMAR O ARQUIVO DE VISUALIZAÇÃO
// Agora a variável $mensagens existe e contém os dados do banco.
require 'respostas.view.php';