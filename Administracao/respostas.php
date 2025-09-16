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
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
} catch (mysqli_sql_exception $e) {
    // Em um ambiente de produção, o ideal é logar o erro em um arquivo.
    // error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
    
    // Exibe uma mensagem genérica e segura para o usuário.
    // Usamos 'die()' para parar a execução e evitar que o resto da página (que depende do banco) tente carregar.
    $erro_conexao = "Não foi possível conectar ao banco de dados. Verifique se o serviço MySQL está ativo e tente novamente.";
    // Incluímos a view para mostrar o erro dentro do layout da página.
    require 'respostas.view.php';
    die();
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