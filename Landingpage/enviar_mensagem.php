<?php
// =========================================================
// SCRIPT PARA RECEBER E GRAVAR MENSAGENS NO BANCO
// =========================================================

// Forçar a exibição de erros durante o desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. VERIFICAR SE O FORMULÁRIO FOI ENVIADO
// Isso impede que o script seja acessado diretamente pela URL
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. COLETAR E VALIDAR OS DADOS DO FORMULÁRIO
    // A função trim() remove espaços em branco extras do início e do fim
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $mensagem = trim($_POST['mensagem']);

    // Validação simples para ver se os campos não estão vazios
    if (empty($nome) || empty($email) || empty($mensagem)) {
        die("Erro: Todos os campos são obrigatórios. Por favor, volte e preencha o formulário completo.");
    }
    
    // Validação do formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erro: O formato do e-mail é inválido. Por favor, insira um e-mail válido.");
    }

    // 3. CONECTAR AO BANCO DE DADOS
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "bepet";

    // Define o modo de relatório de erros do MySQLi para lançar exceções em vez de warnings.
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    } catch (mysqli_sql_exception $e) {
        // Em um ambiente de produção, o ideal é logar o erro em um arquivo.
        // error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
        
        // Exibe uma mensagem genérica e segura para o usuário.
        die("Desculpe, estamos com problemas técnicos em nosso sistema. Por favor, tente novamente mais tarde.");
    }

    // 4. PREPARAR E EXECUTAR A INSERÇÃO SEGURA (PREPARED STATEMENT)
    // O SQL usa "?" como placeholders para os dados
    $sql = "INSERT INTO mensagem (nome, email, mensagem) VALUES (?, ?, ?)";

    // Prepara a declaração SQL para execução
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar a declaração: " . $conexao->error);
    }

    // Vincula as variáveis PHP aos placeholders do SQL.
    // "sss" significa que estamos enviando três variáveis do tipo String (string, string, string)
    $stmt->bind_param("sss", $nome, $email, $mensagem);

    // Executa a declaração
    if ($stmt->execute()) {
        // Se a execução foi bem-sucedida, redireciona o usuário de volta para a página inicial
        // com um parâmetro de sucesso na URL.
        header("Location: BePet.php?status=sucesso#contato");
        exit(); // Garante que o script pare de executar após o redirecionamento
    } else {
        // Se falhou, exibe um erro
        echo "Erro ao enviar a mensagem: " . $stmt->error;
    }

    // 5. FECHAR TUDO
    $stmt->close();
    $conexao->close();

} else {
    // Se alguém tentar acessar o arquivo diretamente
    echo "Acesso negado.";
}
?>