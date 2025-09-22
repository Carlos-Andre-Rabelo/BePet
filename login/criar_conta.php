<?php
// Inicia a sessão
session_start();

$error_message = '';
$success_message = '';

// 1. VERIFICAR SE O FORMULÁRIO FOI ENVIADO
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. CONECTAR AO BANCO DE DADOS
    $servidor = "localhost";
    $usuario = "root";
    $senha_db = "";
    $banco = "bepet";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $conexao = new mysqli($servidor, $usuario, $senha_db, $banco);
    } catch (mysqli_sql_exception $e) {
        die("Desculpe, estamos com problemas técnicos. Tente novamente mais tarde.");
    }

    // 3. COLETAR E VALIDAR DADOS
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha_digitada = trim($_POST['senha']); // Renomeado para clareza

    if (empty($nome) || empty($email) || empty($senha_digitada)) {
        $error_message = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "O formato do e-mail é inválido.";
    } else {
        // 4. VERIFICAR SE O E-MAIL JÁ EXISTE
        $sql_check = "SELECT codigo FROM login WHERE email = ? LIMIT 1";
        $stmt_check = $conexao->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $resultado_check = $stmt_check->get_result();

        if ($resultado_check->num_rows > 0) {
            $error_message = "Este e-mail já está cadastrado. Tente fazer login.";
        } else {
            // 5. CRIPTOGRAFAR A SENHA (HASH)
            $senha_hash = password_hash($senha_digitada, PASSWORD_DEFAULT);

            // 6. INSERIR O NOVO USUÁRIO NO BANCO
            $sql_insert = "INSERT INTO login (nome, email, senha) VALUES (?, ?, ?)";
            $stmt_insert = $conexao->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt_insert->execute()) {
                // Redireciona para a página de login com uma mensagem de sucesso
                header("Location: login.php?status=conta_criada");
                exit;
            } else {
                $error_message = "Erro ao criar a conta. Tente novamente.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - BePet</title>
    <link rel="stylesheet" href="login.css"> <!-- Reutilizando o CSS do login -->
    <link rel="stylesheet" href="criar_conta.css"> <!-- CSS específico para a página de criar conta -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <main class="login-main">
        <div class="login-container">
            <a href="../Landingpage/index.php" class="logo">BePet</a>
            <form action="criar_conta.php" method="POST" class="login-form">
                <h2>Crie sua conta</h2>
                <p>É rápido e fácil.</p>

                <?php if (!empty($error_message)): ?>
                    <div class="login-error"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha forte" required>
                </div>

                <button type="submit">Criar Conta</button>
            </form>
            <p class="create-account">Já possui uma conta? <a href="login.php"><em>Faça login!</em></a></p>
        </div>
    </main>

</body>
</html>