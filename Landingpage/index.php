<?php
session_start(); // Inicia a sessão para verificar se o usuário está logado
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BePet - Cuidando de quem você ama</title>
    <meta name="description" content="A BePet oferece os melhores serviços e produtos para o seu animal de estimação. Banhos, tosa, rações, brinquedos e muito mais!">
    <meta name="keywords" content="petshop, banho e tosa, ração, cachorro, gato, pet">
    <link rel="stylesheet" href="style.css">

    </head>
<body>

    <header>
    <div class="container">
        <a href="#" class="logo">BePet</a>
        
        <nav class="main-nav">
            <ul>
                <li><a href="#servicos">Serviços</a></li>
                <li><a href="#produtos">Produtos</a></li>
                <li><a href="#sobre-nos">Sobre Nós</a></li>
                <li><a href="#depoimentos">Depoimentos</a></li>
                <li><a href="#contato">Contato</a></li>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <!-- Link de Sair para o menu mobile -->
                    <li class="logout-link-mobile"><a href="../login/logout.php">Sair</a></li>
                <?php else: ?>
                    <!-- Link de Entrar para o menu mobile -->
                    <li class="login-link-mobile"><a href="../login/login.php">Entrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="header-actions">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <?php
                    // Pega o primeiro nome para uma saudação mais curta
                    $nome_completo = $_SESSION['nome'];
                    $partes_nome = explode(' ', $nome_completo);
                    $primeiro_nome = htmlspecialchars($partes_nome[0]);
                ?>
                <span class="welcome-message">Olá, <?php echo $primeiro_nome; ?>!</span>
                <a href="../login/logout.php" class="logout-link-desktop">Sair</a>
            <?php else: ?>
                <a href="../login/login.php" class="header-cta-button cta-button">Entrar</a>
            <?php endif; ?>
        </div>

        <button class="menu-mobile-toggle" aria-label="Abrir menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
    </header>

    <main>

        <section id="hero">
            <div class="container">
                <h1>O carinho que seu pet merece, com a confiança que você procura.</h1>
                <p>Agende um serviço ou conheça nossos produtos. Tudo para fazer seu amigo feliz!</p>
                <a href="#contato" class="cta-button">Agende um Horário</a>
            </div>
        </section>

        <section id="servicos">
            <div class="container">
                <h2>Nossos Serviços</h2>
                <div class="servicos-grid">
                    <article class="servico-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/3111/3111399.png" alt="Ícone de um chuveiro e patas">
                        <h3>Banho e Tosa</h3>
                        <p>Higiene completa com os melhores produtos e profissionais cuidadosos.</p>
                    </article>
                    <article class="servico-item">
                        <img src="https://images.vexels.com/media/users/3/151982/isolated/preview/e9241fdcfd59abd050866113be10454d-icono-de-estetoscopio-by-vexels.png" alt="Ícone de um estetoscópio">
                        <h3>Consultas Veterinárias</h3>
                        <p>Cuidado preventivo e tratamento para a saúde do seu pet.</p>
                    </article>
                    <article class="servico-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/4889/4889074.png" alt="Ícone de uma casinha de cachorro">
                        <h3>Day Care (Creche)</h3>
                        <p>Um espaço seguro e divertido para seu pet socializar e gastar energia.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="produtos">
            <div class="container">
                <h2>Produtos em Destaque</h2>
                <div class="produtos-grid">
                    <article class="produto-item">
                        <img src="https://petiser.com.br/wp-content/uploads/2023/03/16-_-Como-entender-as-informacoes-dos-rotulos-de-racao-para-caes.jpg" alt="Saco de ração premium para cães">
                        <h3>Ração Premium Filhotes</h3>
                        <p class="preco">R$ 120,00</p>
                        <button>Comprar</button>
                    </article>
                    <article class="produto-item">
                        <img src="https://www.adoropets.com.br/wp-content/uploads/2020/08/2e82r5f4bf9izoxpl9a9d0znj.jpg" alt="Brinquedo de corda colorido para pets">
                        <h3>Brinquedo de Corda</h3>
                        <p class="preco">R$ 35,00</p>
                        <button>Comprar</button>
                    </article>
                    <article class="produto-item">
                        <img src="https://tse2.mm.bing.net/th/id/OIP.z0amnokqvTmxfGK8kpxV7gAAAA?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Cama macia e confortável para pets">
                        <h3>Caminha Aconchegante</h3>
                        <p class="preco">R$ 99,90</p>
                        <button>Comprar</button>
                    </article>
                </div>
            </div>
        </section>

        <section id="sobre-nos">
            <div class="container">
                <img src="https://s3.nuvemvet.com/blog/wp-content/uploads/2021/12/16140553/produtos-1-626x400.jpg" alt="Equipe da BePet sorrindo com animais de estimação">
                <div>
                    <h2>Quem Somos</h2>
                    <h3>Amor e dedicação em cada detalhe</h3>
                    <p>A BePet nasceu da paixão por animais. Nossa missão é oferecer um ambiente seguro, produtos de alta qualidade e serviços feitos com carinho, tratando cada pet como se fosse nosso.</p>
                    <p>Contamos com uma equipe de profissionais qualificados e apaixonados pelo que fazem.</p>
                </div>
            </div>
        </section>

        <section id="depoimentos">
            <div class="container">
                <h2>O que nossos clientes dizem</h2>
                <figure class="depoimento">
                    <blockquote>
                        <p>"Levei meu cachorro para o primeiro banho na BePet e fiquei impressionada com o cuidado e a atenção da equipe. Ele voltou super cheiroso e feliz!"</p>
                    </blockquote>
                    <figcaption>— Maria S., dona do Tobi</figcaption>
                </figure>
                <figure class="depoimento">
                    <blockquote>
                        <p>"A melhor petshop da região! Sempre encontro tudo que preciso e o atendimento é excelente."</p>
                    </blockquote>
                    <figcaption>— João P., dono da Luna</figcaption>
                </figure>
            </div>
        </section>

        <section id="contato">
            <div class="container">
                <h2>Entre em Contato</h2>
                <div class="contato-wrapper">
                    <div class="form-container">
                        <?php
                        // Verifica se o parâmetro 'status' existe na URL e se seu valor é 'sucesso'
                        if (isset($_GET['status']) && $_GET['status'] === 'sucesso') {
                            // Se sim, exibe a mensagem de sucesso usando a nova classe CSS.
                            echo '<div class="alerta-contato">Mensagem enviada com sucesso! Entraremos em contato em breve.</div>';
                        }
                        ?>

                        <?php
                        // Define as variáveis para o nome e e-mail, preenchendo se o usuário estiver logado
                        $form_nome = '';
                        $form_email = '';
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            $form_nome = isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : '';
                            $form_email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
                        }
                        ?>

                        <form action="enviar_mensagem.php" method="POST">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" value="<?php echo $form_nome; ?>" required>

                            <label for="email">E-mail:</label>
                            <input type="email" id="email" name="email" value="<?php echo $form_email; ?>" required>

                            <label for="mensagem">Mensagem:</label>
                            <textarea id="mensagem" name="mensagem" rows="5" required></textarea>

                            <button type="submit">Enviar Mensagem</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer>
        <div class="container">
            <address class="footer-info">
                <h3>Nossas Informações</h3>
                <p>📍 Rua dos Pets, 123 - Centro</p>
                <p>📞 (99) 99999-8888</p>
                <p>✉️ contato@bepet.com.br</p>
                <p>⏰ Seg à Sáb, das 8h às 18h</p>
            </address>
            <div class="social-links">
                <a href="#" aria-label="Nosso Instagram"><img src="

http://googleusercontent.com/image_collection/image_retrieval/13017793548056348696_0
" alt="Instagram"></a>
                <a href="#" aria-label="Nosso Facebook"><img src="

http://googleusercontent.com/image_collection/image_retrieval/8260928235125470361_0
" alt="Facebook"></a>
                <a href="#" aria-label="Nosso WhatsApp"><img src="

http://googleusercontent.com/image_collection/image_retrieval/15407181813849766191_0
" alt="WhatsApp"></a>
            </div>
            <p class="copyright">&copy; 2025 BePet. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Seleciona os elementos do DOM
        const menuMobileToggle = document.querySelector('.menu-mobile-toggle');
        const mainNav = document.querySelector('.main-nav');

        // Adiciona um evento de clique ao botão do menu
        menuMobileToggle.addEventListener('click', () => {
            // Adiciona/remove a classe 'active' no botão (para animar o 'X')
            menuMobileToggle.classList.toggle('active');
            // Adiciona/remove a classe 'active' na navegação (para mostrar/esconder)
            mainNav.classList.toggle('active');
        });

        // Opcional: Fecha o menu ao clicar em um link
        const navLinks = document.querySelectorAll('.main-nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                menuMobileToggle.classList.remove('active');
                mainNav.classList.remove('active');
            });
        });
    </script>

</body>
</html>