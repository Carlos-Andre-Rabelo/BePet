<?php
// =========================================================
// PARTE 1: LÓGICA PHP COMPLETA
// =========================================================

// Forçar a exibição de todos os erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Variáveis de conexão
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "bepet";

// Conectar ao banco de dados
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// Checar por erros de conexão
if ($conexao->connect_error) {
    die("FALHA NA CONEXÃO: " . $conexao->connect_error);
}

// Criar a consulta SQL para buscar as mensagens
$sql = "SELECT codigo, nome, email, mensagem FROM mensagen ORDER BY codigo DESC";

// Executar a consulta
$resultado = $conexao->query($sql);

// Preparar o array para armazenar as mensagens
$mensagens = [];

// Verificar se a consulta retornou resultados
if ($resultado && $resultado->num_rows > 0) {
    // Loop para coletar todas as linhas da tabela
    while($linha = $resultado->fetch_assoc()) {
        $mensagens[] = $linha;
    }
}
// Se a consulta falhou (por exemplo, erro de sintaxe), a variável $mensagens continuará sendo um array vazio.

// Fechar a conexão com o banco de dados
$conexao->close();

// A partir daqui, o HTML será renderizado.
// A variável $mensagens já está pronta para ser usada.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Teste Final</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* VARIÁVEIS E ESTILOS GLOBAIS */
        :root {
            --cor-primaria: #FF6B6B;
            --cor-secundaria: #6c757d;
            --cor-terciaria: #264653;
            --cor-fundo: #f8f9fa;
            --cor-texto: #4A5568;
            --cor-branco: #ffffff;
            --cor-borda: #E2E8F0;
            --fonte-titulos: 'Poppins', sans-serif;
            --fonte-corpo: 'Lato', sans-serif;
            --box-shadow-light: 0 4px 10px rgba(0, 0, 0, 0.05);
            --border-radius: 12px;
            --transition: all 0.2s ease-out;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-corpo); background-color: var(--cor-fundo); color: var(--cor-texto); line-height: 1.6; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        a { color: var(--cor-terciaria); text-decoration: none; transition: var(--transition); }
        a:hover { color: var(--cor-primaria); }
        h2 { font-family: var(--fonte-titulos); color: var(--cor-terciaria); font-size: 2.5rem; margin-bottom: 40px; text-align: center; }

        /* HEADER */
        header { background-color: var(--cor-branco); padding: 20px 0; box-shadow: var(--box-shadow-light); border-bottom: 1px solid var(--cor-borda); position: sticky; top: 0; z-index: 1000; }
        header .container { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: var(--fonte-titulos); font-size: 2rem; font-weight: 800; }
        .main-nav ul { display: flex; list-style: none; gap: 30px; }
        .main-nav a { font-weight: 600; padding: 8px 0; }
        .main-nav a.active { color: var(--cor-primaria); border-bottom: 3px solid var(--cor-primaria); }
        .header-cta-button { background-color: var(--cor-terciaria); color: var(--cor-branco); padding: 10px 25px; border-radius: 8px; font-weight: 700; }
        .header-cta-button:hover { background-color: #3a5c6d; color: var(--cor-branco); }

        /* MAIN CONTENT - RESPOSTAS */
        #respostas { padding: 80px 0; }
        .lista-respostas { display: grid; gap: 30px; }
        .card-mensagem { background: var(--cor-branco); padding: 30px; border-radius: var(--border-radius); border-left: 6px solid var(--cor-terciaria); box-shadow: var(--box-shadow-light); transition: var(--transition); }
        .card-mensagem:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        .card-mensagem blockquote p { font-style: italic; font-size: 1.1rem; margin-bottom: 1.2rem; }
        .card-mensagem figcaption { text-align: right; font-weight: 700; color: var(--cor-terciaria); }
        .card-mensagem figcaption a { font-weight: 400; font-size: 0.95rem; color: var(--cor-texto); }
        .admin-actions { margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--cor-borda); display: flex; gap: 10px; justify-content: flex-end; }
        .admin-actions button { padding: 10px 20px; border: none; border-radius: 8px; font-family: var(--fonte-corpo); font-weight: 700; cursor: pointer; transition: var(--transition); }
        .admin-actions button:hover { transform: translateY(-2px); opacity: 0.9; }
        button.btn-responder { background-color: var(--cor-secundaria); color: var(--cor-branco); }
        button.btn-excluir { background-color: var(--cor-primaria); color: var(--cor-branco); }
        .aviso-sem-mensagens { background-color: var(--cor-branco); padding: 40px; text-align: center; border-radius: var(--border-radius); box-shadow: var(--box-shadow-light); }
        
        /* FOOTER */
        footer { background-color: var(--cor-terciaria); color: rgba(255, 255, 255, 0.8); text-align: center; padding: 40px 0; margin-top: 60px; }
        footer .container { display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>

<header>
    <div class="container">
        <a href="#" class="logo">AdminPainel</a>
        <nav class="main-nav">
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#" class="active">Mensagens</a></li>
                <li><a href="#">Configurações</a></li>
            </ul>
        </nav>
        <a href="#" class="header-cta-button">Sair</a>
    </div>
</header>

<main>
    <section id="respostas">
        <div class="container">
            <h2>Mensagens Recebidas</h2>
            <div class="lista-respostas">
                
                <?php if (empty($mensagens)): ?>
                    <div class="aviso-sem-mensagens">
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
                            <div class="admin-actions">
                               <button class="btn-responder">Responder</button>
                               <a href="excluir.php?codigo=<?= $msg['codigo']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta mensagem?');">
                                   <button class="btn-excluir">Excluir</button>
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

</body>
</html>