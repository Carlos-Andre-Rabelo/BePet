<?php
session_start();

// 1. VERIFICAR SE O USUÁRIO É ADMINISTRADOR
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// 2. CONECTAR AO BANCO DE DADOS E BUSCAR PRODUTOS
$produtos = [];
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "bepet";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    $sql = "SELECT id, nome, preco, caminho_imagem FROM produtos ORDER BY id DESC";
    $resultado = $conexao->query($sql);
    if ($resultado) {
        $produtos = $resultado->fetch_all(MYSQLI_ASSOC);
    }
    $conexao->close();
} catch (mysqli_sql_exception $e) {
    $erro_conexao = "Não foi possível buscar os produtos. Tente novamente mais tarde.";
}

$pageTitle = "Gerenciar Produtos";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Painel Admin</title>
    <link rel="stylesheet" href="Estilo_administração.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="container">
        <a href="respostas.php" class="logo">Administração - BePet</a>
        <nav class="main-nav">
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="respostas.php">Mensagens</a></li>
                <li><a href="listar_produtos.php" class="active">Produtos</a></li>
                <li class="nav-cta-mobile"><a href="../login/logout.php" class="header-cta-button">Sair</a></li>
            </ul>
        </nav>
        <a href="../login/logout.php" class="header-cta-button desktop-only">Sair</a>
        <button class="menu-mobile-toggle" aria-label="Abrir menu"><span class="bar"></span><span class="bar"></span><span class="bar"></span></button>
    </div>
</header>

<main>
    <section id="gerenciar-produtos" style="padding: 60px 0;">
        <div class="container">
            <div class="header-actions-produtos"> 
                <h2><?php echo $pageTitle; ?></h2>
                <a href="gerenciar_produto.php" class="btn btn-adicionar">Cadastrar Novo</a>
            </div>

            <?php
            // Exibe mensagens de sucesso ou erro vindas de outras páginas
            if (isset($_SESSION['mensagem'])) {
                // Adapta a classe do alerta com base no tipo de mensagem
                $classe_alerta = $_SESSION['tipo_mensagem'] === 'success' ? 'alerta-sucesso' : 'alerta-danger';
                echo '<div class="alerta ' . $classe_alerta . '" style="text-align: left;">' . htmlspecialchars($_SESSION['mensagem']) . '</div>';
                unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']);
            }
            ?>

            <?php if (isset($erro_conexao)): ?>
                <div class="alerta alerta-danger"><?php echo $erro_conexao; ?></div>
            <?php elseif (empty($produtos)): ?>
                <div class="card-mensagem" style="text-align: center;"><p>Nenhum produto cadastrado ainda.</p></div>
            <?php else: ?>
                <div class="produtos-admin-grid">
                    <?php foreach ($produtos as $produto): ?>
                        <article class="produto-card">
                            <img src="../<?php echo htmlspecialchars($produto['caminho_imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                            <div class="produto-card-content">
                                <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                                <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                                <div class="produto-card-actions">
                                    <a href="gerenciar_produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-responder">Editar</a>
                                    <a href="processa_produto.php?acao=excluir&id=<?php echo $produto['id']; ?>" class="btn btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este produto? Esta ação não pode ser desfeita.');">Excluir</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> BePet Ltda.</p>
        <span>Painel Administrativo</span>
    </div>
</footer>

<script>
    (function() {
        const menuMobileToggle = document.querySelector('.menu-mobile-toggle');
        const mainNav = document.querySelector('.main-nav');
        if (menuMobileToggle && mainNav) {
            menuMobileToggle.addEventListener('click', () => {
                menuMobileToggle.classList.toggle('active');
                mainNav.classList.toggle('active');
            });
        }
    })();
</script>

</body>
</html>