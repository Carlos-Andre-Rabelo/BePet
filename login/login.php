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
            <form action="" method="POST" class="login-form">
                <h2>Acesse sua conta</h2>
                <p>Bem-vindo de volta! Sentimos sua falta.</p>
                
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
        </div>
    </main>

</body>
</html>