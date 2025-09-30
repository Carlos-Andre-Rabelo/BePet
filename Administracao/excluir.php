<?php
// =========================================================
// SCRIPT PARA EXCLUIR MENSAGENS DO BANCO DE DADOS
// =========================================================

// Forçar a exibição de erros durante o desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. VERIFICAR SE O PARÂMETRO 'codigo' FOI ENVIADO VIA GET
if (isset($_GET['codigo']) && !empty($_GET['codigo'])) {

    // 2. COLETAR E VALIDAR O CÓDIGO
    $codigo = (int)$_GET['codigo']; // Converte para inteiro para segurança

    // 3. CONECTAR AO BANCO DE DADOS
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "bepet";

    // Define o modo de relatório de erros do MySQLi para lançar exceções.
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    } catch (mysqli_sql_exception $e) {
        // Loga o erro e exibe uma mensagem genérica.
        // error_log("Erro de conexão no script de exclusão: " . $e->getMessage());
        die("Ocorreu um erro de comunicação com o servidor. A operação não pôde ser concluída.");
    }

    // 4. PREPARAR E EXECUTAR A EXCLUSÃO SEGURA (PREPARED STATEMENT)
    $sql = "DELETE FROM mensagem WHERE codigo = ?";

    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar a declaração: " . $conexao->error);
    }

    // Vincula o parâmetro 'codigo'
    // "i" significa que estamos enviando uma variável do tipo Integer
    $stmt->bind_param("i", $codigo);

    // Executa a declaração
    if ($stmt->execute()) {
        // Se a exclusão foi bem-sucedida, redireciona de volta para a página de respostas
        // com um parâmetro de status para exibir uma mensagem de sucesso.
        header("Location: listar_respostas.php?status=excluido");
        exit(); // Garante que o script pare de executar após o redirecionamento
    } else {
        // Se falhou, exibe um erro
        echo "Erro ao excluir a mensagem: " . $stmt->error;
    }

    // 5. FECHAR TUDO
    $stmt->close();
    $conexao->close();

} else {
    // Se o parâmetro 'codigo' não for passado na URL
    echo "Acesso negado ou código da mensagem inválido.";
    exit();
}
?>
