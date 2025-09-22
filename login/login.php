<?php
// Inicia a sessão. Isso deve ser a primeira coisa no seu script.
session_start();

// Se o usuário já estiver logado, redireciona para a página do painel
// Se o usuário já estiver logado, redireciona para a página correta (admin ou landing page)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Verifica se a 'role' do usuário é de administrador
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header('Location: ../administracao/respostas.php'); // Redireciona admin para a página de respostas
    } else {
        header('Location: ../Landingpage/index.php'); // Redireciona usuário comum para a Landing Page
    }
    exit; // Importante sair após o redirecionamento
}

$login_error = '';

// 1. VERIFICAR SE O FORMULÁRIO FOI ENVIADO
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. CONECTAR AO BANCO DE DADOS (mesmas credenciais do outro script)
    $servidor = "localhost";
    $usuario = "root";
    $senha_db = ""; // Renomeado para não conflitar com a senha do formulário
    $banco = "bepet";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $conexao = new mysqli($servidor, $usuario, $senha_db, $banco);
    } catch (mysqli_sql_exception $e) {
        // Em produção, logue o erro. Para o usuário, mostre uma mensagem genérica.
        // error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
        die("Desculpe, estamos com problemas técnicos. Tente novamente mais tarde.");
    }

    // 3. COLETAR E VALIDAR DADOS
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($email) && !empty($senha) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // 4. PREPARAR E EXECUTAR A CONSULTA SEGURA
        $sql = "SELECT codigo, nome, senha, tipo_usuario FROM login WHERE email = ? LIMIT 1";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $user = $resultado->fetch_assoc();

            // 5. VERIFICAR A SENHA
            if (password_verify($senha, $user['senha'])) {
                // Senha correta! Iniciar a sessão do usuário.
                session_regenerate_id(); // Previne session fixation
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['codigo'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['role'] = $user['tipo_usuario']; // Armazena o tipo de usuário na sessão

                // 6. REDIRECIONAR COM BASE NO TIPO DE USUÁRIO
                if ($user['tipo_usuario'] === 'admin') {
                    header("Location: ../administracao/respostas.php"); // Redireciona admin para a página de respostas
                } else {
                    header("Location: ../Landingpage/index.php"); // Redireciona usuário comum para a Landing Page
                }
                exit; // Importante sair após o redirecionamento
            }
        }
    }
    // Se chegou até aqui, o login falhou.
    $login_error = "E-mail ou senha inválidos.";
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BePet</title>
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <main class="login-main">
        <div class="login-container">
            <a href="../Landingpage/index.php" class="logo">BePet</a>
            <form action="login.php" method="POST" class="login-form">
                <h2>Acesse sua conta</h2>
                <p>Bem-vindo de volta! Sentimos sua falta.</p>
                
                <?php if (isset($_GET['status']) && $_GET['status'] === 'conta_criada'): ?>
                    <div class="login-success">Conta criada com sucesso! Faça o login para continuar.</div>
                <?php endif; ?>

                <?php if (!empty($login_error)): ?>
                    <div class="login-error"><?php echo htmlspecialchars($login_error); ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Sua senha" required>
                </div>

                <button type="submit">Entrar</button>
            </form>
            <p class="create-account">Não possui conta? <a href="criar_conta.php"><em>Crie uma!</em></a></p>
        </div>
    </main>

</body>
</html>