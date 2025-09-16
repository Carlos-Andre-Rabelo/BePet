<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respostas do Formulário - Painel Admin</title>
    
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
                    <li><a href="respostas.php" class="active">Mensagens</a></li>
                    <li><a href="#">Configurações</a></li>
                    <!-- O botão Sair será movido para dentro do menu no mobile via CSS -->
                    <li class="nav-cta-mobile"><a href="../Landingpage/BePet.php" class="header-cta-button">Sair</a></li>
                </ul>
            </nav>
            <!-- Botão Sair para Desktop -->
            <a href="../Landingpage/BePet.php" class="header-cta-button desktop-only">Sair</a>
            <!-- Botão Hambúrguer para Mobile -->
            <button class="menu-mobile-toggle" aria-label="Abrir menu">
                <span class="bar"></span><span class="bar"></span><span class="bar"></span>
            </button>
        </div>
    </header>

    <main>
        <section id="respostas">
            <div class="container">
                <?php
                // Verifica se o parâmetro 'status' existe na URL e se seu valor é 'excluido'
                if (isset($_GET['status']) && $_GET['status'] === 'excluido') {
                    // Se sim, exibe a mensagem de sucesso
                    echo '<div class="alerta alerta-sucesso">Mensagem excluída com sucesso!</div>';
                }
                ?>
                <h2>Mensagens Recebidas</h2>
                <div class="lista-respostas">
                    
                    <?php if (empty($mensagens)): ?>
                        <div class="card-mensagem" style="text-align: center;">
                            <p>Nenhuma mensagem recebida até o momento.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($mensagens as $msg): ?>
                            <article class="card-mensagem">
                                <blockquote>
                                    <p><?= htmlspecialchars($msg['mensagem']); ?></p>
                                </blockquote>
                                <figcaption>
                                    <strong><?= htmlspecialchars($msg['nome']); ?></strong><br>
                                    <a href="mailto:<?= htmlspecialchars($msg['email']); ?>">
                                        <?= htmlspecialchars($msg['email']); ?>
                                    </a>
                                </figcaption>
                                <?php
                                    // --- LÓGICA PARA CRIAR O LINK DO GMAIL ---
                                    // 1. Define o assunto do e-mail de resposta.
                                    $assunto = "Re: Contato via site BePet";

                                    // 2. Monta o corpo do e-mail, citando a mensagem original.
                                    // A quebra de linha \n é importante para a formatação.
                                    $corpo_email = "Olá " . htmlspecialchars($msg['nome']) . ",\n\nEm resposta à sua mensagem:\n\n\"" . htmlspecialchars($msg['mensagem']) . "\"\n\n\n";

                                    // 3. Constrói a URL final para o Gmail, codificando os parâmetros para que funcionem corretamente em uma URL.
                                    $link_gmail = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($msg['email']) . "&su=" . urlencode($assunto) . "&body=" . urlencode($corpo_email);
                                ?>
                                <div class="admin-actions">
                                   <a href="<?= $link_gmail; ?>" class="btn-responder" target="_blank" rel="noopener noreferrer">
                                       Responder
                                   </a>
                                   <a href="excluir.php?codigo=<?= $msg['codigo']; ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta mensagem?');">
                                       Excluir
                                   </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y'); ?> BePet Ltda.</p>
            <span>Painel Administrativo</span>
        </div>
    </footer>

    <script>
        // Este script remove o parâmetro 'status' da URL após a página carregar.
        // Isso evita que a mensagem de sucesso seja exibida novamente ao atualizar a página.
        (function() {
            // Pega a URL atual do navegador
            const url = new URL(window.location.href);

            // Verifica se o parâmetro 'status' existe na URL
            if (url.searchParams.has('status')) {
                // Atualiza a URL na barra de endereço do navegador, removendo todos os parâmetros,
                // sem recarregar a página.
                window.history.replaceState({}, document.title, url.pathname);
            }
        })();
    </script>

    <script>
        // Script para controlar o menu mobile
        (function() {
            const menuMobileToggle = document.querySelector('.menu-mobile-toggle');
            const mainNav = document.querySelector('.main-nav');

            if (menuMobileToggle && mainNav) {
                menuMobileToggle.addEventListener('click', () => {
                    // Adiciona/remove a classe 'active' no botão (para animar o 'X')
                    menuMobileToggle.classList.toggle('active');
                    // Adiciona/remove a classe 'active' na navegação (para mostrar/esconder)
                    mainNav.classList.toggle('active');
                });
            }
        })();
    </script>
</body>
</html>