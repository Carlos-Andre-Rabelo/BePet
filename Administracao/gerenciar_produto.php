<?php
session_start();

// 1. VERIFICAR SE O USUÁRIO É ADMINISTRADOR
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// --- LÓGICA PARA DETERMINAR SE É CADASTRO OU EDIÇÃO ---
$is_edit = isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT);
$produto = [
    'id' => '',
    'nome' => '',
    'descricao' => '',
    'preco' => '',
    'caminho_imagem' => ''
];
$pageTitle = "Cadastrar Novo Produto";

if ($is_edit) {
    $id_produto = (int)$_GET['id'];
    $pageTitle = "Editar Produto";

    // CONECTAR AO BANCO E BUSCAR OS DADOS DO PRODUTO
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "bepet";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $conexao = new mysqli($servidor, $usuario, $senha, $banco);
        $sql = "SELECT id, nome, descricao, preco, caminho_imagem FROM produtos WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_produto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $produto_db = $resultado->fetch_assoc();
        $stmt->close();
        $conexao->close();

        if (!$produto_db) {
            throw new Exception("Produto não encontrado.");
        }
        $produto = $produto_db; // Preenche o array com os dados do banco
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
        $_SESSION['tipo_mensagem'] = "danger";
        header("Location: listar_produtos.php");
        exit();
    }
}
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
        <a href="listar_respostas.php" class="logo">Administração - BePet</a>
        <nav class="main-nav">
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="listar_respostas.php">Mensagens</a></li>
                <li><a href="listar_produtos.php" class="active">Produtos</a></li>
                <li class="nav-cta-mobile"><a href="../login/logout.php" class="header-cta-button">Sair</a></li>
            </ul>
        </nav>
        <a href="../login/logout.php" class="header-cta-button desktop-only">Sair</a>
        <button class="menu-mobile-toggle" aria-label="Abrir menu"><span class="bar"></span><span class="bar"></span><span class="bar"></span></button>
    </div>
</header>

<main>
    <section id="gerenciar-produto" style="padding: 60px 0;">
        <div class="container">
            <h2><?php echo $pageTitle; ?><?php if ($is_edit) echo ': ' . htmlspecialchars($produto['nome']); ?></h2>
            
            <?php
            // Exibe mensagens de sucesso ou erro
            if (isset($_SESSION['mensagem'])) {
                echo '<div class="alert alert-' . $_SESSION['tipo_mensagem'] . '" role="alert">' . $_SESSION['mensagem'] . '</div>';
                unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']);
            }
            ?>

            <div class="card-mensagem" style="border-left-color: var(--cor-primaria);">
                <h3 style="margin-bottom: 20px; font-family: var(--fonte-titulos); color: var(--cor-terciaria);">Formulário</h3>
                <div class="card-body">
                    <form action="processa_produto.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="acao" value="<?php echo $is_edit ? 'editar' : 'cadastrar'; ?>">
                        <?php if ($is_edit): ?>
                            <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
                            <input type="hidden" name="imagem_atual" value="<?php echo $produto['caminho_imagem']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="nome_produto">Nome do Produto:</label>
                            <input type="text" id="nome_produto" name="nome_produto" value="<?php echo htmlspecialchars($produto['nome']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="descricao_produto">Descrição:</label>
                            <textarea id="descricao_produto" name="descricao_produto" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="preco_produto">Preço:</label>
                            <input type="number" step="0.01" id="preco_produto" name="preco_produto" value="<?php echo htmlspecialchars($produto['preco']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <?php if ($is_edit && $produto['caminho_imagem']): ?>
                                <label>Imagem Atual:</label>
                                <img src="../<?php echo htmlspecialchars($produto['caminho_imagem']); ?>" alt="Imagem atual" style="max-width: 150px; height: auto; border-radius: 8px; display: block; margin-bottom: 10px;">
                                <label for="imagem_produto">Trocar Imagem (opcional):</label>
                            <?php else: ?>
                                <label for="imagem_produto">Imagem do Produto:</label>
                            <?php endif; ?>
                            <input type="file" id="imagem_produto" name="imagem_produto" accept="image/png, image/jpeg, image/webp" <?php echo !$is_edit ? 'required' : ''; ?> style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                            <div class="form-text"><?php echo $is_edit ? 'Deixe em branco para manter a imagem atual.' : 'Apenas .png, .jpg, .jpeg ou .webp. Máx: 2MB.'; ?></div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-adicionar">Salvar</button>
                            <a href="listar_produtos.php" class="btn btn-responder">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

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