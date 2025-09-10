<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BePet - Cuidando de quem você ama</title>
    <meta name="description" content="A BePet oferece os melhores serviços e produtos para o seu animal de estimação. Banhos, tosa, rações, brinquedos e muito mais!">
    <meta name="keywords" content="petshop, banho e tosa, ração, cachorro, gato, pet">
    <link rel="stylesheet" href="BePet.css">

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
            </ul>
        </nav>

        <a href="#contato" class="header-cta-button cta-button">Agende Agora</a>

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
                        <img src="https://www.drhato.com.br/wp-content/uploads/2019/11/banhoetosa-2.png" alt="Ícone de um chuveiro e patas">
                        <h3>Banho e Tosa</h3>
                        <p>Higiene completa com os melhores produtos e profissionais cuidadosos.</p>
                    </article>
                    <article class="servico-item">
                        <img src="https://images.vexels.com/media/users/3/151982/isolated/preview/e9241fdcfd59abd050866113be10454d-icono-de-estetoscopio-by-vexels.png" alt="Ícone de um estetoscópio">
                        <h3>Consultas Veterinárias</h3>
                        <p>Cuidado preventivo e tratamento para a saúde do seu pet.</p>
                    </article>
                    <article class="servico-item">
                        <img src="

https://images.vexels.com/media/users/3/151982/isolated/preview/e9241fdcfd59abd050866113be10454d-icono-de-estetoscopio-by-vexels.png" alt="Ícone de uma casinha de cachorro">
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
                        <img src="http://googleusercontent.com/image_collection/image_retrieval/3276409944853620800_0" alt="Saco de ração premium para cães">
                        <h3>Ração Premium Filhotes</h3>
                        <p class="preco">R$ 120,00</p>
                        <button>Comprar</button>
                    </article>
                    <article class="produto-item">
                        <img src="http://googleusercontent.com/image_collection/image_retrieval/6591216267161208840_0" alt="Brinquedo de corda colorido para pets">
                        <h3>Brinquedo de Corda</h3>
                        <p class="preco">R$ 35,00</p>
                        <button>Comprar</button>
                    </article>
                    <article class="produto-item">
                        <img src="http://googleusercontent.com/image_collection/image_retrieval/2197547633251177481_0" alt="Cama macia e confortável para pets">
                        <h3>Caminha Aconchegante</h3>
                        <p class="preco">R$ 99,90</p>
                        <button>Comprar</button>
                    </article>
                </div>
            </div>
        </section>

        <section id="sobre-nos">
            <div class="container">
                <img src="http://googleusercontent.com/image_collection/image_retrieval/8469230135986068697_0" alt="Equipe da BePet sorrindo com animais de estimação">
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

                   <form action="enviar_mensagem.php" method="POST">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required>

                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="mensagem">Mensagem:</label>
                        <textarea id="mensagem" name="mensagem" rows="5" required></textarea>

                        <button type="submit">Enviar Mensagem</button>
                    </form>
                    <address>
                        <h3>Nossas Informações</h3>
                        <p>📍 Rua dos Pets, 123 - Centro</p>
                        <p>📞 (99) 99999-8888</p>
                        <p>✉️ contato@bepet.com.br</p>
                        <p>⏰ Seg à Sáb, das 8h às 18h</p>
                    </address>
                </div>
            </div>
        </section>

    </main>

    <footer>
        <div class="container">
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
            <p>&copy; 2025 BePet. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>