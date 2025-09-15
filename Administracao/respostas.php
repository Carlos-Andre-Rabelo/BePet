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
    die("Falha na conexão: " . $conexao->connect_error);
}

// 3. CRIAR A QUERY SQL (CONSULTA) CORRIGIDA
// Selecionamos todas as colunas da tabela "mensagen".
// CORREÇÃO: Trocamos "ORDER BY data_envio" por "ORDER BY codigo DESC"
// pois a coluna "data_envio" não existe na sua tabela.
$sql = "SELECT codigo, nome, email, mensagem FROM mensagen ORDER BY codigo DESC";

// 4. EXECUTAR A QUERY E OBTER O RESULTADO
$resultado = $conexao->query($sql);

// 5. TRANSFORMAR O RESULTADO EM UM ARRAY
// Criamos um array vazio para guardar as mensagens.
$mensagens = [];
if ($resultado->num_rows > 0) {
    // Se a consulta retornou uma ou mais linhas, percorremos cada uma
    // e a adicionamos ao nosso array $mensagens.
    while($linha = $resultado->fetch_assoc()) {
        $mensagens[] = $linha;
    }
}

// 6. FECHAR A CONEXÃO COM O BANCO
$conexao->close();

// 7. CHAMAR O ARQUIVO DE VISUALIZAÇÃO
// Agora a variável $mensagens existe e contém os dados do banco.
require 'respostas.view.php';