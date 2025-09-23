<?php
session_start(); // Inicia a sessão para verificar se o usuário está logado

// --- INÍCIO DA LÓGICA PARA BUSCAR PRODUTOS ---
$produtos = []; // Inicializa o array de produtos

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "bepet";

try {
    // Usar mysqli com tratamento de erro
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);

    // Query para buscar os produtos mais recentes (ex: os últimos 6)
    $sql_produtos = "SELECT nome, preco, caminho_imagem FROM produtos ORDER BY id DESC LIMIT 6";
    $resultado_produtos = $conexao->query($sql_produtos);

    if ($resultado_produtos) {
        $produtos = $resultado_produtos->fetch_all(MYSQLI_ASSOC);
    }

    $conexao->close();
} catch (mysqli_sql_exception $e) {
    // Em um ambiente real, é melhor logar o erro do que exibi-lo.
    // A página continuará a ser renderizada, e a seção de produtos mostrará uma mensagem de "nenhum produto".
}
// --- FIM DA LÓGICA PARA BUSCAR PRODUTOS ---
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

    <!-- 1. Adicionar o CSS do Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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
                <!-- 2. Estrutura do Slider Swiper.js -->
                <div class="swiper produtos-slider">
                    <div class="swiper-wrapper">
                        <?php if (!empty($produtos)): ?>
                            <?php foreach ($produtos as $produto): ?>
                                <!-- Cada produto agora é um 'swiper-slide' -->
                                <div class="swiper-slide">
                                    <article class="produto-item">
                                        <img src="../<?php echo htmlspecialchars($produto['caminho_imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                        <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                                        <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                                        <button>Comprar</button>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="aviso-sem-produtos">
                                <p>Nenhum produto em destaque no momento. Volte em breve!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Adiciona setas de navegação -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <!-- Adiciona paginação (bolinhas) -->
                    <div class="swiper-pagination"></div>
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

    <!-- 3. Adicionar o JavaScript do Swiper.js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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

    <!-- 4. Inicializar o Swiper.js -->
    <script>
        const swiper = new Swiper('.produtos-slider', {
            // Ativa o loop contínuo
            loop: true,
            // Ativa o autoplay
            autoplay: {
                delay: 6000, // Aumentado para 6 segundos
                disableOnInteraction: false, // Não para o autoplay ao interagir
            },
            
            // Torna o slider arrastável no desktop
            grabCursor: true,

            // Paginação (bolinhas)
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Setas de navegação
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // Breakpoints responsivos
            breakpoints: {
                // Para telas mobile (largura >= 0px)
                0: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                // Para telas de tablet (largura >= 768px)
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // Para telas de desktop (largura >= 1024px)
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });
    </script>

</body>
</html>